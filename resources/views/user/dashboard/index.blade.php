@extends('layouts.base')

@section('content')
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- PHP Information Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-purple-500 p-3 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 14H10m4 0V6m6 12H4v4h16v-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold dark:text-gray-200">PHP Status</h2>
                    </div>
                </div>
                <div class="mt-4 dark:text-gray-400">
                    <h3 class="text-lg font-semibold">PHP Version & Modules</h3>
                    <p>PHP Version: {{ $phpInfo['version'] }}</p>
                    <p class="font-semibold">Loaded Modules:</p>
                    <p>
                        @foreach ($phpInfo['modules'] as $index => $module)
                            {{ $module }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>

            <!-- System Status Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-green-500 p-3 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 14H10m4 0V6m6 12H4v4h16v-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold dark:text-gray-200">System Status</h2>
                    </div>
                </div>
                <div class="mt-4 dark:text-gray-400">
                    <h3 class="text-lg font-semibold">General Info</h3>
                    <p>Hostname: {{ $serverStatus['general_info']['hostname'] }}</p>
                    <p>OS: {{ $serverStatus['general_info']['os'] }}</p>
                    <p>Server Time: {{ $serverStatus['general_info']['server_time'] }}</p>
                    <p>Uptime: {{ $serverStatus['general_info']['uptime'] }}</p>
                </div>
                <div class="mt-4 dark:text-gray-400">
                    <h3 class="text-lg font-semibold">CPU Usage</h3>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 mt-2">
                        <div class="bg-blue-500 h-4 rounded-full"
                             style="width: {{ $serverStatus['cpu_usage'] }}%"></div>
                    </div>
                </div>
                <div class="mt-4 dark:text-gray-400">
                    <h3 class="text-lg font-semibold">RAM Usage</h3>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 mt-2">
                        <div class="bg-green-500 h-4 rounded-full"
                             style="width: {{ $serverStatus['ram_usage'] }}%"></div>
                    </div>
                </div>
            </div>


            <!-- Coin Status Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="bg-yellow-500 p-3 rounded-full text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l6.16-3.422a12.083 12.083 01.84 2.429L12 14zm0 0l-6.16 3.422a12.083 12.083 00-.84-2.429L12 14z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14v8m0 0H9m3 0h3"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold dark:text-gray-200">Coin Status</h2>
                    </div>
                </div>
                <div class="mt-4 dark:text-gray-400">
                    <!-- Bitcoin Status -->
                    <div>
                        <p class="font-semibold">Bitcoin Wallet Status:
                            <span
                                class="{{ $btcWalletInfo['status'] === 'error' ? 'text-red-500' : 'text-green-500' }}">
            {{ $btcWalletInfo['name'] }} loaded.
        </span>
                        </p>

                        <p class="font-semibold">Bitcoin Status:
                            <span
                                class="{{ isset($bitcoinStatus['connected']) && $bitcoinStatus['connected'] ? 'text-green-500' : 'text-red-500' }}">
            {{ isset($bitcoinStatus['connected']) && $bitcoinStatus['connected'] ? 'Connected' : 'Disconnected' }}
        </span>
                        </p>

                        @if (isset($bitcoinStatus['connected']) && $bitcoinStatus['connected'])
                            <p>Network: {{ $bitcoinStatus['network'] }}</p>
                            <p>Last Block: <span class="font-mono">{{ $bitcoinStatus['latest_block'] }}</span></p>
                            <p>Connected Nodes: <span class="font-mono">{{ $bitcoinStatus['connected_nodes'] }}</span>
                            </p>
                            <p>Difficulty: <span class="font-mono">{{ $bitcoinStatus['difficulty'] }}</span></p>
                            <p>Hash Rate: <span class="font-mono">{{ $bitcoinStatus['hash_rate'] }}</span></p>
                            <p>Mempool Size: <span class="font-mono">{{ $bitcoinStatus['mempool_size'] }}</span></p>
                            <p>Last Block Time: <span class="font-mono">{{ $bitcoinStatus['last_block_time'] }}</span>
                            </p>
                            <p>Version: <span class="font-mono">{{ $bitcoinStatus['version'] }}</span></p>
                        @endif
                    </div>


                    <!-- Monero Status -->
                    <div class="mt-4">
                        <p class="font-semibold">Monero Wallet Status:
                            <span class="{{ $moneroStatus['walletConnected'] ? 'text-green-500' : 'text-red-500' }}">
                                 {{ $moneroStatus['walletConnected'] ? 'Connected' : 'Disconnected' }}
                             </span>
                        </p>
                        <p class="font-semibold">Monero Daemon Status:
                            <span class="{{ $moneroStatus['daemonConnected'] ? 'text-green-500' : 'text-red-500' }}">
                                 {{ $moneroStatus['daemonConnected'] ? 'Connected' : 'Disconnected' }}
                             </span>
                        </p>
                        @if ($moneroStatus['daemonConnected'])
                            <p>Network: {{ $moneroStatus['daemonStatus']['network'] }}</p>
                            <p>Last Block: <span class="font-mono">{{ $moneroStatus['height'] }}</span></p>
                            <p>Connected Nodes: <span
                                    class="font-mono">{{ $moneroStatus['daemonStatus']['nodes'] }}</span></p>
                            <p>Difficulty: <span
                                    class="font-mono">{{ $moneroStatus['daemonStatus']['difficulty'] }}</span></p>
                            <p>Hash Rate: <span
                                    class="font-mono">{{ $moneroStatus['daemonStatus']['hash_rate'] }}</span></p>
                            <p>Mempool Size: <span
                                    class="font-mono">{{ $moneroStatus['daemonStatus']['mempool_size'] }}</span></p>
                            <p>Last Block Time: <span
                                    class="font-mono">{{ $moneroStatus['daemonStatus']['last_block_time'] }}</span></p>
                            <p>Version: <span class="font-mono">{{ $moneroStatus['daemonStatus']['version'] }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
