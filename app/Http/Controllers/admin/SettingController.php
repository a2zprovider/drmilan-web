<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $setting = Setting::first();
        $editData =  $setting->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('setting');
        return view('backend.inc.setting.edit', $data);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $setting = Setting::first();
        $record     = $setting;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.setting'))->with('success', 'Success! Record has been updated');
        }
    }

    public function logo_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/setting/';
            if (!file_exists($optimizePath)) {
                mkdir($optimizePath, 0755, true);
            }
            $name    = 'logo.' . $file->extension();
            $optimizeImage->save($optimizePath . $name, 72);
        }

        return response()->json(['success' => $name]);
    }

    public function logo_delete(Request $request)
    {
        $filename =  $request->get('filename');
        $path = public_path() . '/images/setting/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function footerlogo_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/setting/';
            if (!file_exists($optimizePath)) {
                mkdir($optimizePath, 0755, true);
            }
            $name    = 'footerlogo.' . $file->extension();
            $optimizeImage->save($optimizePath . $name, 72);
        }

        return response()->json(['success' => $name]);
    }

    public function footerlogo_delete(Request $request)
    {
        $filename =  $request->get('filename');
        $path = public_path() . '/images/setting/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function favicon_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/setting/';
            if (!file_exists($optimizePath)) {
                mkdir($optimizePath, 0755, true);
            }
            $name    = 'favicon.' . $file->extension();
            $optimizeImage->save($optimizePath . $name, 72);
        }

        return response()->json(['success' => $name]);
    }

    public function favicon_delete(Request $request)
    {
        $filename =  $request->get('filename');
        $path = public_path() . '/images/setting/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function homeedit(Request $request)
    {
        $setting = Setting::first();
        $editData =  $setting->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('setting');
        return view('backend.inc.homesetting.edit', $data);
    }

    public function homeupdate(Request $request)
    {
        $setting = Setting::first();
        $record     = $setting;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.homesetting'))->with('success', 'Success! Record has been updated');
        }
    }
}
