<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use DataTables;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.slider.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.slider.index');
    }

    public function create()
    {
        return view('backend.inc.slider.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'title'  => 'required|string',
            'image'  => 'required',
        ];

        $messages = [
            'title'  => 'Please Enter Name.',
            'image'  => 'Please Select Image'
        ];

        $request->validate($rules, $messages);

        $record           = new Slider;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.slider.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.slider.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Slider $slider)
    {
        //
    }

    public function edit(Request $request, Slider $slider)
    {
        $editData =  $slider->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('slider');
        return view('backend.inc.slider.edit', $data);
    }

    public function update(Request $request, Slider $slider)
    {
        $rules = [
            'title'  => 'required|string',
            'image'  => 'required',
        ];
        $messages = [
            'title'  => 'Please Enter Name.',
            'image'  => 'Please Select Image'
        ];
        $request->validate($rules, $messages);

        $record     = $slider;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.slider.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect(route('admin.slider.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Slider::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.slider.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/slider/';
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
        $path = public_path() . '/images/slider/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
