<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function setting(Request $request)
    {
        $setting = Setting::first();

        $data = [
            'setting' => $setting,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }
}
