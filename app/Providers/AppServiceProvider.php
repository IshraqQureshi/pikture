<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
