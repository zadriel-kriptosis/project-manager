<?php

return [
    'active_coins' => [
        'xmr' => 'Monero',
        'btc' => 'Bitcoin',
    ],

    'network' => [
        'xmr' => env('MONERO_NETWORK', 'stagenet'),
        'btc' => env('BTC_NETWORK', 'testnet'),
    ],

    'svg' => function($coin) {
        return "images/svg/coin/$coin.svg";
    },

    'networks' => [
        'btc' => [
            'mainnet' => [
                'scheme' => env('BITCOIND_SCHEME_MAINNET', 'http'),
                'host' => env('BITCOIND_HOST_MAINNET', '127.0.0.1'),
                'port' => env('BITCOIND_PORT_MAINNET', 8332),
                'username' => env('BITCOIND_USERNAME_MAINNET', 'username'),
                'password' => env('BITCOIND_PASSWORD_MAINNET', 'password'),
                'min_confirm' => env('BITCOIND_CONFIRM_MAINNET', 2),
                'fallback_fee_enabled' => env('BITCOIN_FALLBACK_FEE_ENABLED_MAINNET', false),
                'fallback_fee_rate' => env('BITCOIN_FALLBACK_FEE_RATE_MAINNET', 20),
            ],
            'testnet' => [
                'scheme' => env('BITCOIND_SCHEME_TESTNET', 'http'),
                'host' => env('BITCOIND_HOST_TESTNET', '127.0.0.1'),
                'port' => env('BITCOIND_PORT_TESTNET', 18332),
                'username' => env('BITCOIND_USERNAME_TESTNET', 'username'),
                'password' => env('BITCOIND_PASSWORD_TESTNET', 'password'),
                'min_confirm' => env('BITCOIND_CONFIRM_TESTNET', 2),
                'fallback_fee_enabled' => env('BITCOIN_FALLBACK_FEE_ENABLED_TESTNET', false),
                'fallback_fee_rate' => env('BITCOIN_FALLBACK_FEE_RATE_TESTNET', 20),
            ],
        ],
        'xmr' => [
            'mainnet' => [
                'host' => env('MONERO_HOST_MAINNET', '127.0.0.1'),
                'port' => env('MONERO_PORT_MAINNET', 18083),
                'ssl' => env('MONERO_SSL_MAINNET', false),
                'username' => env('MONERO_USERNAME_MAINNET', ''),
                'password' => env('MONERO_PASSWORD_MAINNET', ''),
            ],
            'stagenet' => [
                'host' => env('MONERO_HOST_STAGENET', '127.0.0.1'),
                'port' => env('MONERO_PORT_STAGENET', 38083),
                'ssl' => env('MONERO_SSL_STAGENET', false),
                'username' => env('MONERO_USERNAME_STAGENET', ''),
                'password' => env('MONERO_PASSWORD_STAGENET', ''),
            ],
        ],
    ],

    'daemons' => [
        'xmr' => [
            'mainnet' => [
                'host' => env('MONERO_DAEMON_HOST_MAINNET', '127.0.0.1'),
                'port' => env('MONERO_DAEMON_PORT_MAINNET', 18081),
                'ssl' => env('MONERO_DAEMON_SSL_MAINNET', false),
                'username' => env('MONERO_DAEMON_USERNAME_MAINNET', ''),
                'password' => env('MONERO_DAEMON_PASSWORD_MAINNET', ''),
            ],
            'stagenet' => [
                'host' => env('MONERO_DAEMON_HOST_STAGENET', '127.0.0.1'),
                'port' => env('MONERO_DAEMON_PORT_STAGENET', 38081),
                'ssl' => env('MONERO_DAEMON_SSL_STAGENET', false),
                'username' => env('MONERO_DAEMON_USERNAME_STAGENET', ''),
                'password' => env('MONERO_DAEMON_PASSWORD_STAGENET', ''),
            ],
        ],
    ],
];
