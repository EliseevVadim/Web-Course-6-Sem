<?php

namespace App\Http\Controllers;

use App\Imports\ActivitiesImport;
use App\Models\Activity;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use \Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['store', 'storeWithGoogleDrive']]);
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
        $attachment = $this->storeAndParse($request);
        return response()->json([
            'message' => 'Файл был успешно загружен',
            'fileName' => $attachment->path
        ]);
    }

    public function storeWithGoogleDrive(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'attachment' => 'required|max:1024|mimes:csv,xlsx,xlsm'
        ]);
        Storage::disk('google')->putFileAs('', $request->attachment, $request->name);
        $attachment = $this->storeAndParse($request);
        return response()->json([
            'message' => 'Файл был успешно загружен',
            'fileName' => $attachment->path
        ]);
    }

    public function dataView() {
        $activities = Activity::join('groups', 'activities.GroupId', '=', 'groups.id')
            ->join('disciplines', 'activities.DisciplineId', '=', 'disciplines.id')
            ->orderByDesc('Date')
            ->select(['activities.*', 'groups.GroupName', 'disciplines.DisciplineName'])
            ->paginate(10);
        return view('dataView', ['data' => $activities]);
    }

    private function storeAndParse(Request $request): Attachment
    {
        $attachment = new Attachment;
        $attachment->name = $request->name;
        $attachment->path = $attachment->upload($request->attachment);
        $attachment->save();
        $data = Excel::import(new ActivitiesImport, storage_path('/app/public/'.$attachment->path));
        return $attachment;
    }
}
