<?php

namespace App\Providers;

use App\Facades\PermissionsCheckerFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\PermissionsChecker;

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
    public function boot()
    {
        Paginator::useBootstrap();
        Blade::if('admin', function () {
            return PermissionsCheckerFacade::instance()->isAdmin();
        });

        Blade::if('canDeleteFromStorage', function () {
            return PermissionsCheckerFacade::instance()->canDeleteStorageFiles();
        });

        Blade::if('canDeleteFromGoogleDrive', function () {
            return PermissionsCheckerFacade::instance()->canDeleteFromGoogleDrive();
        });

        Blade::if('canCheckFiles', function () {
            return PermissionsCheckerFacade::instance()->canCheckFiles();
        });
    }
}
