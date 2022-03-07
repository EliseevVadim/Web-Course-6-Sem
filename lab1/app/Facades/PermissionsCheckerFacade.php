<?php

namespace App\Facades;

use App\Providers\FacadesServiceProvider;
use App\Services\PermissionsChecker;
use Illuminate\Support\Facades\Facade;

/**
 * @method static PermissionsChecker instance()
 */
class PermissionsCheckerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permissions.checker';
    }
}
