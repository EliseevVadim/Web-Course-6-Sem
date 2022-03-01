<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PermissionsChecker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LoadedFilesController extends Controller
{
    public function viewFiles() {
        if (!PermissionsChecker::canCheckFiles())
            abort(404);
        $storageFiles = File::files(storage_path('app/public/uploads'));
        $googleFiles = collect(Storage::disk('google')->listContents("1Pu2OEGuC5xumrk3ZR4t1yJ_JumFHQ69F", false));
        return view('filesView', ['storageFiles' => $storageFiles, 'googleFiles' => $googleFiles]);
    }

    public function deleteFileFromStorage($name) {
        File::delete(storage_path('app/public/uploads/').$name);
    }

    public function deleteFileFromGoogleDrive($name) {
        Storage::disk('google')->delete($name);
    }
}
