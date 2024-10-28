<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
//            general
            ['key' => 'app_name', 'value' => 'ZadrielsTicket'],
            ['key' => 'app_url', 'value' => 'https://zadriel.com'],
            ['key' => 'app_logo', 'value' => 'images/logo.svg'],
            ['key' => 'app_email', 'value' => 'contact@zadriel.com'],
            ['key' => 'app_pubkey', 'value' => 'pubkey'],
            ['key' => 'app_footertext', 'value' => 'All rights reserved.'],
//            sociality
            ['key' => 'app_telegram', 'value' => 'ZadrielsTicket'],
            ['key' => 'app_github', 'value' => 'ZadrielsTicket'],
            ['key' => 'app_dread', 'value' => 'ZadrielsTicket'],
//            apperance
            ['key' => 'default_theme', 'value' => 'null'],
            ['key' => 'default_themecolor', 'value' => 'dark'],
//            localization
            ['key' => 'default_fiat', 'value' => 'usd'],
            ['key' => 'default_lang', 'value' => 'en'],
            ['key' => 'default_timezone', 'value' => 'UTC'],
//            homepage texts
            ['key' => 'homepage_main_text', 'value' => 'ticket
'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
            Cache::tags('Settings')->forever($setting['key'], $setting['value']);
        }
    }
}
