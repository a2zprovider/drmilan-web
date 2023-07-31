<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Medicine;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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
        $query = Doctor::latest();
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        $doctors = $query->get();
        // dd($doctors);
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

    public function help(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'mobile'    => 'required',
            'message'   => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input = [
                'name'      => $request->name,
                'mobile'    => $request->mobile,
                'email'     => $request->email,
                'message'   => $request->message,
            ];

            $inquiry = new Inquiry();
            $inquiry->fill($input);
            $inquiry->save();

            $re = [
                'status'    => true,
                'message'   => 'Message send successfully.',
                'data'      => $inquiry,
            ];
        }
        return response()->json($re);
    }

    public function reviews(Request $request)
    {
        $query = Review::latest();
        if ($request->doctor) {
            $query->where('doctor_id', $request->doctor);
        }
        $reviews = $query->get();

        $data = [
            'reviews' => $reviews,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }

    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'    => 'required',
            'message'   => 'required',
            'doctor_id' => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input            = $request->except('_token');
            $input['user_id'] = auth()->user()->id;
            $input['name'] = auth()->user()->name;

            $review = new Review();
            $review->fill($input);
            $review->save();

            $re = [
                'status'    => true,
                'message'   => 'Review added successfully.',
                'data'      => $review,
            ];
        }
        return response()->json($re);
    }

    public function bookappointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'gender'    => 'required',
            'age'       => 'required',
            'mobile'    => 'required',
            'date'      => 'required',
            'doctor_id' => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input            = $request->except('_token');
            $input['user_id'] = auth()->user()->id;

            $appointment = new Appointment();
            $appointment->fill($input);
            $appointment->save();

            $appointment = Appointment::find($appointment->id);

            $re = [
                'status'    => true,
                'message'   => 'Appointment booked successfully.',
                'data'      => $appointment,
            ];
        }
        return response()->json($re);
    }

    public function events(Request $request)
    {
        $events = Event::latest()->get();

        $data = [
            'events' => $events,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }

    public function appointments(Request $request)
    {
        $query = Appointment::latest();
        if ($request->doctor) {
            $query->where('doctor_id', $request->doctor);
        }
        if ($request->user) {
            $query->where('user_id', auth()->user()->id);
        }
        $appointments = $query->get();

        $data = [
            'appointments' => $appointments,
        ];
        $re = [
            'status'    => true,
            'data'      => $data,
        ];
        return response()->json($re);
    }

    public function updateappointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'        => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input            = $request->except('_token', 'id');
            $appointment = Appointment::find($request->id);
            $appointment->update($input);

            $re = [
                'status'    => true,
                'message'   => 'Appointment updated successfully.',
                'data'      => $appointment,
            ];
        }
        return response()->json($re);
    }

    public function useredit(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input            = $request->except('_token');

            $user = User::find(auth()->user()->id);
            $user->update($input);

            $re = [
                'status'    => true,
                'message'   => 'User edited successfully.',
                'data'      => $user,
            ];
        }
        return response()->json($re);
    }

    public function medicine(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'      => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $input            = $request->except('_token');
            // $input['user_id'] = auth()->user()->id;

            $appointment = new Medicine();

            if ($request->hasFile('image')) {
                $file = $request->image;
                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/medicine/';
                if (!file_exists($optimizePath)) {
                    mkdir($optimizePath, 0755, true);
                }
                $name    = time() . '.' . $file->extension();
                $optimizeImage->save($optimizePath . $name, 72);

                $input['image'] = $name;
            }

            $appointment->fill($input);
            $appointment->save();

            $re = [
                'status'    => true,
                'message'   => 'Medicine booked successfully.',
                'data'      => $appointment,
            ];
        }
        return response()->json($re);
    }
}
