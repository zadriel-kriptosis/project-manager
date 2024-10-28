<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // First, check if the database is connected since it's common to both conditions.
        if ($this->isDatabaseConnected()) {
            if ($this->tableExists('settings')) {
                $this->cacheSettings();
            }
        }

    }

    /**
     * Cache all settings indefinitely without the 'settings.' prefix.
     */
    private function cacheSettings()
    {
        Setting::all()->each(function ($setting) {
            Cache::tags('Settings')->rememberForever($setting->key, function () use ($setting) {
                return $setting->value;
            });
        });
    }

    /**
     * Check database connection.
     */
    private function isDatabaseConnected()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if the table exists in the database.
     */
    private function tableExists($tableName)
    {
        return Schema::hasTable($tableName);
    }
}
