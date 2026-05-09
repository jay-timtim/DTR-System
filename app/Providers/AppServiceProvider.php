<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Wrap the database check in a try-catch block
        try {
            // Prevent this from running during command-line tool execution (like migrations or composer builds)
            if (!app()->runningInConsole() && Schema::hasTable('settings')) {
                $settings = DB::table('settings')->pluck('value', 'key')->toArray();
                config(['app_settings' => $settings]);
            }
        } catch (\Exception $e) {
            // Log the issue instead of throwing a 500 error page if the database isn't reachable yet
            Log::warning('Could not load settings from database: ' . $e->getMessage());
        }
    }
}
