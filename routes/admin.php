<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['guest:admin'], 'namespace' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/checklogin', 'LoginController@checklogin')->name('checklogin');
});

Route::group(['middleware' => ['auth:admin'], 'namespace' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'DashboardController@index')->name('home');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::post('/newsletter/deleteAll', 'InquiryController@deleteAll')->name('newsletter.deleteAll');
    Route::post('/inquiry/deleteAll', 'InquiryController@deleteAll')->name('inquiry.deleteAll');
    Route::post('/doctor/deleteAll', 'DoctorController@deleteAll')->name('doctor.deleteAll');
    Route::post('/notification/deleteAll', 'NotificationController@deleteAll')->name('notification.deleteAll');
    Route::post('/faq/deleteAll', 'FaqController@deleteAll')->name('faq.deleteAll');

    // Doctor
    Route::post('/doctor/image', 'DoctorController@image_upload')->name('doctor.image');
    Route::post('/doctor/image/detele', 'DoctorController@image_delete')->name('doctor.image.delete');
    Route::post('/doctor/multi-image', 'DoctorController@multi_image_upload')->name('doctor.multi.image');
    Route::post('/doctor/multi-image/detele', 'DoctorController@multi_image_delete')->name('doctor.multi.image.delete');

    Route::resources([
        'doctor' => 'DoctorController',
        'notification' => 'NotificationController',
        'faq' => 'FaqController',
        'inquiry' => 'InquiryController',
    ]);

    Route::get('/newsletter', 'InquiryController@newsletter')->name('newsletter.index');

    // Setting
    Route::get('/setting', 'SettingController@edit')->name('setting');
    Route::post('/setting', 'SettingController@update')->name('setting.update');
    Route::post('/setting/logo', 'SettingController@logo_upload')->name('setting.logo');
    Route::post('/setting/logo/detele', 'SettingController@logo_delete')->name('setting.logo.delete');
    Route::post('/setting/footerlogo', 'SettingController@footerlogo_upload')->name('setting.footerlogo');
    Route::post('/setting/footerlogo/detele', 'SettingController@footerlogo_delete')->name('setting.footerlogo.delete');
    Route::post('/setting/favicon', 'SettingController@favicon_upload')->name('setting.favicon');
    Route::post('/setting/favicon/detele', 'SettingController@favicon_delete')->name('setting.favicon.delete');

    // Home Setting
    Route::get('/homesetting', 'SettingController@homeedit')->name('homesetting');
    Route::post('/homesetting', 'SettingController@homeupdate')->name('homesetting.update');

    Route::get('/change-password', 'LoginController@change_password')->name('user.changepassword');
    Route::post('/change-password', 'LoginController@save_password')->name('user.savepassword');

    Route::post('/inquery/{id}', 'DashboardController@destroy')->name('inquery_delete');

    Route::post('/category/deleteAll', 'CategoryController@deleteAll')->name('category.deleteAll');
    Route::post('/blog/deleteAll', 'BlogController@deleteAll')->name('blog.deleteAll');
    Route::post('/blogcategory/deleteAll', 'BlogcategoryController@deleteAll')->name('blogcategory.deleteAll');
    Route::post('/tag/deleteAll', 'TagController@deleteAll')->name('tag.deleteAll');
    Route::post('/slider/deleteAll', 'SliderController@deleteAll')->name('slider.deleteAll');
    Route::post('/page/deleteAll', 'PageController@deleteAll')->name('page.deleteAll');
    Route::post('/service/deleteAll', 'ServiceController@deleteAll')->name('service.deleteAll');
    Route::post('/galary/deleteAll', 'GalaryController@deleteAll')->name('galary.deleteAll');
    Route::post('/review/deleteAll', 'ReviewController@deleteAll')->name('review.deleteAll');
    Route::post('/user/deleteAll', 'UserController@deleteAll')->name('user.deleteAll');
    Route::get('/user/status/{user:id}', 'UserController@status')->name('user.status');

    // Blog
    Route::post('/blog/image', 'BlogController@image_upload')->name('blog.image');
    Route::post('/blog/image/detele', 'BlogController@image_delete')->name('blog.image.delete');

    // Page
    Route::post('/page/image', 'PageController@image_upload')->name('page.image');
    Route::post('/page/image/detele', 'PageController@image_delete')->name('page.image.delete');

    // Notification
    Route::post('/notification/image', 'NotificationController@image_upload')->name('notification.image');
    Route::post('/notification/image/detele', 'NotificationController@image_delete')->name('notification.image.delete');

    // Service
    Route::post('/service/image', 'ServiceController@image_upload')->name('service.image');
    Route::post('/service/image/detele', 'ServiceController@image_delete')->name('service.image.delete');

    // Galary
    Route::post('/galary/image', 'GalaryController@image_upload')->name('galary.image');
    Route::post('/galary/image/detele', 'GalaryController@image_delete')->name('galary.image.delete');

    // review
    Route::post('/review/image', 'ReviewController@image_upload')->name('review.image');
    Route::post('/review/image/detele', 'ReviewController@image_delete')->name('review.image.delete');

    // Category
    Route::post('/category/image', 'CategoryController@image_upload')->name('category.image');
    Route::post('/category/image/detele', 'CategoryController@image_delete')->name('category.image.delete');

    // Blog Category
    Route::post('/blogcategory/image', 'BlogcategoryController@image_upload')->name('blogcategory.image');
    Route::post('/blogcategory/image/detele', 'BlogcategoryController@image_delete')->name('blogcategory.image.delete');

    // Slider
    Route::post('/slider/image', 'SliderController@image_upload')->name('slider.image');
    Route::post('/slider/image/detele', 'SliderController@image_delete')->name('slider.image.delete');

    Route::resources([
        'blog'      => 'BlogController',
        'category'  => 'CategoryController',
        'blogcategory' => 'BlogcategoryController',
        'tag' => 'TagController',
        'slider' => 'SliderController',
        'page' => 'PageController',
        'service' => 'ServiceController',
        'galary' => 'GalaryController',
        'review' => 'ReviewController',
        'user' => 'UserController',
    ]);
});
