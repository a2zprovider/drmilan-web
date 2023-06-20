<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['as' => 'api.'], function () {
    Route::post('/login', 'LoginController@login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', 'AuthController@me');

    Route::get('/doctors', 'HomeController@doctors');
    Route::get('/category', 'HomeController@category');
    Route::get('/faqs', 'HomeController@faqs');
    Route::get('/notifications', 'HomeController@notifications');

    Route::get('/setting', 'HomeController@setting');
    Route::get('/logout', 'LoginController@logout');
});
