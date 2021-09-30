<?php

namespace App\Providers;

use App\Charts\DispatcherChart;
use App\Charts\DispatcherPieChart;
use App\Charts\WatcherChart;
use App\Charts\WatcherPieChart;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            WatcherChart::class,
            WatcherPieChart::class,
            DispatcherChart::class,
            DispatcherPieChart::class
        ]);
    }
}
