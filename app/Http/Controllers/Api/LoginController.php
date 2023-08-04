<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'    => 'required',
        ]);
        if ($validator->fails()) {
            $re = [
                'status'    => false,
                'message'   => 'Validations errors found.',
                'errors'    => $validator->errors()
            ];
        } else {
            $user_exists = User::where('mobile', $request->mobile)->exists();
            if ($user_exists) {
                $user = User::where('mobile', $request->mobile)->first();
                if ($user->status == 'true') {
                    if ($request->otp) {
                        if ($user->otp == $request->otp) {
                            Auth::login($user);
                            $user = Auth::user();

                            $input = [
                                'name'          => @request('name') ? request('name') : request('mobile'),
                                'device_type'   => request('device_type') && request('device_type') != '' ? request('device_type') : null,
                                'device_id'     => request('device_id') && request('device_id') != '' ? request('device_id') : null,
                                'fcm_id'        => request('fcm_id') && request('fcm_id') != '' ? request('fcm_id') : null,
                                'otp'           => null
                            ];

                            $user->update($input);
                            $token = $user->createToken('drmilap')->plainTextToken;
                            if ($user->role == 'doctor') {
                                $doctor = Doctor::where('user_id', $user->id)->first();
                                $user->doctor = $doctor;
                            }
                            $re = [
                                'status'    => true,
                                'message'   => 'Account Login successfully.',
                                'data'      => $user,
                                'token'     => $token,
                            ];
                        } else {
                            $re = [
                                'status'    => false,
                                'message'   => 'Error!! Otp not matched.',
                            ];
                        }
                    } else {
                        // $otp = \random_int(100000, 999999);
                        $otp = 123456;
                        $user->otp = $otp;
                        $user->save();

                        $re = [
                            'status'    => true,
                            'message'   => 'Otp send successfully.',
                            'data'      => $user,
                            'otp'       => $otp,
                        ];
                    }
                } else {
                    $re = [
                        'status'    => false,
                        'message'   => 'Account not active. please raise a request help.',
                        'is_verified' => false,
                    ];
                }
            } else {
                $input = [
                    'name' => $request->name ? $request->name : $request->mobile,
                    'mobile' => $request->mobile,
                    'role'  => 'user',
                ];

                $user = new User();
                $user->fill($input);

                // $otp = \random_int(100000, 999999);
                $otp = 123456;
                $user->otp = $otp;
                $user->save();

                $re = [
                    'status'    => true,
                    'message'   => 'Otp send successfully.',
                    'data'      => $user,
                    'otp'       => $otp,
                ];
            }
        }
        return response()->json($re);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->device_type  = null;
        $user->device_id    = null;
        $user->fcm_id       = null;
        $user->save();

        auth()->user()->tokens()->delete();
        // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        $re = [
            'status'    => true,
            'message'   => 'Success! You are logout successfully.',
        ];

        return response()->json($re);
    }
}
