<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModerationController extends Controller
{
    public function openServiceAdding()
    {
        $types = ServiceType::query()->select('id', 'type_name')->get();
        return view('addService', compact('types'));
    }

    public function openServiceTypeAdding()
    {
        return view('addServiceType');
    }

    public function addService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'discount' => 'nullable|integer|between:0,100',
            'image' => 'required|mimes:png,jpg,jpeg,gif'
        ]);
        $file = $request->file('image');
        $filename = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $path = Storage::disk('uploads')->putFileAs('/', $file, $filename);
        $service = new Service;
        $service->fill($request->all());
        $service->image_path = $path;
        $service->save();
        return redirect("openServiceAdding");
    }

    public function addServiceType(Request $request)
    {
        $request = $request->validate([
            "type_name" => "required|string"
        ]);
        $serviceType = new ServiceType;
        $serviceType->fill($request);
        $serviceType->save();
        return redirect("addServiceType");
    }
}
