<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Imports\ActivitiesImport;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['store']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'attachment' => 'required|max:1024|mimes:csv,xlsx,xlsm'
        ]);
        $attachment = new Attachment;
        $attachment->name = $request->name;
        $attachment->path = $attachment->upload($request->attachment);
        $attachment->save();
        $data = Excel::import(new ActivitiesImport, storage_path('/app/public/'.$attachment->path));
        return response()->json([
            'message' => 'Файл был успешно загружен',
            'fileName' => $attachment->path
        ]);
    }
}
