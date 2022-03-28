<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function setUserId(Request $request)
    {
        session(['user_id' => $request->id]);
    }

    public function getUserId()
    {
        $id = session('user_id');
        return response()->json([
            "id" => $id
        ]);
    }

    public function unauthUser()
    {
        session()->forget(['user_id']);
    }
}
