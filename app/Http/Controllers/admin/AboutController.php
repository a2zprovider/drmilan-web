<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(About $about)
    {
        //
    }

    public function edit(Request $request)
    {
        $about = About::first();
        $editData =  $about->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('about');
        return view('backend.inc.about.edit', $data);
    }

    public function update(Request $request)
    {
        $about = About::first();
        $record     = $about;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.about.edit'))->with('success', 'Success! Record has been updated');
        }
    }

    public function destroy(About $about)
    {
        //
    }
    
    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/about/';
            if (!file_exists($optimizePath)) {
                mkdir($optimizePath, 0755, true);
            }
            $name    = time() . '.' . $file->extension();
            $optimizeImage->save($optimizePath . $name, 72);
        }

        return response()->json(['success' => $name]);
    }

    public function image_delete(Request $request)
    {
        $filename =  $request->get('filename');
        $path = public_path() . '/images/about/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
