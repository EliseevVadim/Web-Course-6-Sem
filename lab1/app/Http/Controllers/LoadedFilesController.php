<?php

namespace App\Http\Controllers;

use App\Facades\PermissionsCheckerFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PermissionsChecker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View;

class LoadedFilesController extends Controller
{
    public function viewFiles() {
        if (!PermissionsCheckerFacade::instance()->canCheckFiles())
            abort(404);
        $storageFiles = File::files(storage_path('app/public/uploads'));
        $googleFiles = collect(Storage::disk('google')->listContents(env('GOOGLE_DRIVE_FOLDER_ID'), false));
        return view('filesView', compact('storageFiles', 'googleFiles'));
    }

    public function deleteFileFromStorage($name) {
        File::delete(storage_path('app/public/uploads/').$name);
    }

    public function deleteFileFromGoogleDrive($name) {
        Storage::disk('google')->delete($name);
    }
}
