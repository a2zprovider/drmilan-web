<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
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

    public function doctors(Request $request)
    {
        $doctors = Doctor::get();

        $data = [
            'doctors' => $doctors,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }

    public function category(Request $request)
    {
        $category = Category::get();

        $data = [
            'category' => $category,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }

    public function faqs(Request $request)
    {
        $faqs = Faq::get();

        $data = [
            'faqs' => $faqs,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }
    public function notifications(Request $request)
    {
        $notifications = Notification::get();

        $data = [
            'notifications' => $notifications,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }
}
