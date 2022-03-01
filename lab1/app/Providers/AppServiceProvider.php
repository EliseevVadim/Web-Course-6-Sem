<?php

namespace App\Providers;

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
            return PermissionsChecker::isAdmin();
        });

        Blade::if('canDeleteFromStorage', function () {
            return PermissionsChecker::canDeleteStorageFiles();
        });

        Blade::if('canDeleteFromGoogleDrive', function () {
           return PermissionsChecker::canDeleteStorageFiles();
        });

        Blade::if('canCheckFiles', function () {
            return PermissionsChecker::canCheckFiles();
        });
    }
}
