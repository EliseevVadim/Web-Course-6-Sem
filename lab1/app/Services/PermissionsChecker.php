<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionsChecker
{
    private static $filesCheckers = [1, 3, 4, 5, 6];
    private static $storageFilesDeleters = [1, 4, 5];
    private static $googleFilesDeleters = [1, 3, 5];

    public function instance()
    {
        return $this;
    }

    public function isAdmin() : bool
    {
        return Auth::user()->role_id === 1;
    }

    public function canCheckFiles() : bool
    {
        return Auth::user() !== null && in_array(Auth::user()->role_id, PermissionsChecker::$filesCheckers);
    }

    public function canDeleteStorageFiles() : bool
    {
        return in_array(Auth::user()->role_id, PermissionsChecker::$storageFilesDeleters);
    }

    public function canDeleteFromGoogleDrive() : bool
    {
        return in_array(Auth::user()->role_id, PermissionsChecker::$googleFilesDeleters);
    }
}
