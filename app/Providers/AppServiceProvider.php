<?php

namespace App\Providers;

use App\Services\SeatService;
use App\Services\SeatSelectService;
use App\Services\GetPassengerService;
use App\Services\GroupPassengerService;
use Illuminate\Support\ServiceProvider;
use App\Services\GetBoardingPassService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeatSelectService::class, function ($app) {
                return new SeatSelectService(
                    $app->make(SeatService::class),
                    $app->make(GetBoardingPassService::class),
                    $app->make(GroupPassengerService::class),
                    $app->make(GetPassengerService::class)
                );
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
