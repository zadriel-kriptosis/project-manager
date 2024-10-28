<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all sessions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        switch(config('session.driver')) {
            case 'file':
                $this->info('Clearing file sessions...');
                array_map('unlink', glob(storage_path('framework/sessions/*')));
                break;

            case 'database':
                $this->info('Clearing database sessions...');
                \Illuminate\Support\Facades\DB::table(config('session.table'))->delete();
                break;

            case 'redis':
                $this->info('Clearing redis sessions...');
                \Illuminate\Support\Facades\Redis::flushdb();
                break;

            default:
                $this->info('Unable to clear session for driver: ' . config('session.driver'));
                break;
        }

        $this->info('Sessions cleared!');
        return 0;
    }

}
