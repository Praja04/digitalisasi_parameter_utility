<?php

namespace App\Providers;

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
        //
        if (!function_exists('getSatuan')) {
            function getSatuan($type)
            {
                return match ($type) {
                    'V-AVG' => 'Volt',
                    'I-Avg' => 'A',
                    'P-Tol' => 'kW',
                    'E-Del' => 'MWh',
                    default => '',
                };
            }
        }
    }

    
}
