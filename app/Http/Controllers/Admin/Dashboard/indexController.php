<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use League\CommonMark\CommonMarkConverter;


class indexController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(PermissionMiddleware::using('systemdashboard-list'), only: ['export']),
            new Middleware(PermissionMiddleware::using('systemdashboard-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('systemdashboard-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('systemdashboard-destroy'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('systemdashboard-ban'), only: ['ban_user']),
            new Middleware(PermissionMiddleware::using('cashdesk-list'), only: ['cashdeskIndex']),
            new Middleware(PermissionMiddleware::using('cashdesk-edit'), only: ['ban_user']),
        ];
    }

    public function index()
    {
        // Get markdown from cache
        $markdown = Cache::tags('Settings')->get('homepage_main_text');
        $converter = new CommonMarkConverter();
        $html = $converter->convert($markdown);

        // Fetch companies the user owns or is involved in via projects
        $companies = auth()->user()->allCompanies();

        // Fetch user's direct projects and company projects
        $userProjects = auth()->user()->projects; // Directly assigned projects

//        // Fetch projects of companies owned by the user
//        $companyProjects = collect();
//        foreach ($companies as $company) {
//            $companyProjects = $companyProjects->merge($company->projects);
//        }
//
//        // Merge both project collections and remove duplicates
//        $allProjects = $userProjects->merge($companyProjects)->unique('id');

        // Fetch process records
        $processRecords = auth()->user()->processRecords;

        // Fetch Demands based on user's associated projects
//        $demands = \App\Models\Demand::whereIn('project_id', $allProjects->pluck('id'))->get();

        $demands = \App\Models\Demand::whereIn('project_id', $userProjects->pluck('id'))->get();

        // Pass data to the view
        return view('home', [
            'homepage_main_text' => $html,
            'companies' => $companies, // All companies the user is involved with
            'projects' => $userProjects, // All relevant projects
            'processRecords' => $processRecords,
            'demands' => $demands, // All relevant demands
        ]);
    }

    public function cashdeskIndex()
    {
        $page_title = __('admin.cash_desk');

        $activeCoins = collect(config('coins.active_coins'));

        $formattedCoins = $activeCoins->map(function ($name, $symbol) {
            return [
                'name' => "$name (" . strtoupper($symbol) . ")",
                'symbol' => strtolower($symbol),
            ];
        });

        $itemsPerPage = "10";


        return view('admin.cashdesk.index', [
            'page_title' => $page_title,
            'activeCoins' => $formattedCoins,
            'commissions_data' => $commissions_data,
            'totalInvoices' => $statusCounts['total'],
            'pendingInvoices' => $statusCounts['pending'],
            'completedInvoices' => $statusCounts['completed'],
            'cancelledInvoices' => $statusCounts['cancelled'],
            'totalBitcoinEarnings' => $totalBitcoinEarnings,
            'totalBitcoinEarningsInUSD' => $totalBitcoinEarningsInUSD,
            'totalMoneroEarnings' => $totalMoneroEarnings,
            'totalMoneroEarningsInUSD' => $totalMoneroEarningsInUSD,
            'totalEarningsInUSD' => $totalEarningsInUSD,
            'totalEscrowBTC' => $totalEscrowBTC,
            'totalEscrowXMR' => $totalEscrowXMR,
            'totalExchange' => $totalExchange,
        ]);
    }

    private function getBitcoinStatus(BitcoinService $service): array
    {
        try {
            return [
                'connected' => true, // Assume connected if no exceptions
                'latest_block' => $service->getLatestBlock(),
                'connected_nodes' => $service->getConnectedNodes(),
                'difficulty' => $service->getDifficulty(),
                'hash_rate' => $service->getHashRate(),
                'mempool_size' => $service->getMempoolSize(),
                'last_block_time' => $service->getLastBlockTime(),
                'version' => $service->getVersion(),
                'network' => $service->getNetworkType(),
            ];
        } catch (\Exception $e) {
            \Log::error("Bitcoin connection failed: " . $e->getMessage());
            return $this->getDisconnectedStatus();
        }
    }

    private function getMoneroStatus(MoneroService $service): array
    {
        $daemonConnected = $service->checkDaemonConnection();
        $walletConnected = $service->checkWalletConnection();

        if ($daemonConnected) {
            return [
                'daemonConnected' => $daemonConnected,
                'walletConnected' => $walletConnected,
                'daemonStatus' => [
                    'lastBlock' => $service->getLatestBlock(),
                    'nodes' => $service->getConnectedNodes(),
                    'difficulty' => $service->getDifficulty(),
                    'hash_rate' => $service->getHashRate(),
                    'mempool_size' => $service->getMempoolSize(),
                    'last_block_time' => $service->getLastBlockTime(),
                    'version' => $service->getVersion(),
                    'network' => $service->getNetworkType(),
                ],
                'height' => $service->getLatestBlock(),
            ];
        }

        return [
            'daemonConnected' => $daemonConnected,
            'walletConnected' => $walletConnected,
            'daemonStatus' => $this->getDisconnectedStatus(),
            'height' => 'N/A',
        ];
    }

    private function getDisconnectedStatus(): array
    {
        return [
            'lastBlock' => 'N/A',
            'nodes' => 'N/A',
            'difficulty' => 'N/A',
            'hash_rate' => 'N/A',
            'mempool_size' => 'N/A',
            'last_block_time' => 'N/A',
            'version' => 'N/A',
            'network' => 'N/A',
        ];
    }

    private function getSystemStatus(ServerStatusService $service): array
    {
        if (strtolower(PHP_OS) === 'winnt') {
            return [
                'cpu_usage' => 10,
                'ram_usage' => 50,
                'uptime' => '0 days, 0 hours, 0 minutes',
                'general_info' => [
/*                    'hostname' => gethostname(),
                    'os' => php_uname(),*/
                    'hostname' => 'wserver2016',
                    'os' => 'Windows NT wserver2016 10.0 AMD64',
                    'server_time' => date('Y-m-d H:i:s'),
                    'uptime' => '0 days, 0 hours, 0 minutes',
                ],
            ];
        }

        return [
            'cpu_usage' => $service->getCpuUsage(),
            'ram_usage' => $service->getRamUsage(),
            'uptime' => $service->getUptime(),
            'general_info' => $service->getGeneralInfo(),
        ];
    }

}
