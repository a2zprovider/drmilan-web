<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Doctor;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Doctor::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.doctor.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('category', function ($row) {
                    $pro = Category::find($row->category_id);
                    $cat = $pro ? $pro->title : '';
                    return $cat;
                })
                ->rawColumns(['category', 'action'])
                ->make(true);
        }

        return view('backend.inc.doctor.index');
    }

    public function create()
    {
        $category = Category::get();
        $categoryArr  = ['' => 'Select category'];
        if (!$category->isEmpty()) {
            foreach ($category as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }

        $availableArr  = [
            'true' => 'In-Stock',
            'false' => 'Out-Stock'
        ];
        $featureArr  = [
            'top' => 'Top Doctor',
            'feature' => 'Feature Doctor',
            'new' => 'New Arrivals',
        ];

        $data = compact('categoryArr', 'availableArr', 'featureArr');
        return view('backend.inc.doctor.add', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'  => 'required|string',
            'image'  => 'required'
        ];

        $messages = [
            'record.title'  => 'Please Enter Name.',
            'image'  => 'Please Select Image'
        ];

        $request->validate($rules, $messages);

        $record           = new Doctor;
        $input            = $request->except('_token');

        $input['field'] = $request->field ? json_encode($request->field) : '{"name":[],"value":[]}';

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $imgs = [];
            foreach ($files as $f) {
                $optimizeImage = Image::make($f);
                $optimizePath = public_path() . '/images/doctor/imgs/';
                if (!file_exists($optimizePath)) {
                    mkdir($optimizePath, 0755, true);
                }
                $image = explode(".", $f->getClientOriginalName());
                $image_name = $image[0];
                $name = time() . Str::slug($image_name, '-') . '.' . $f->getClientOriginalExtension();
                $optimizeImage->save($optimizePath . $name, 72);
                $imgs[] = $name;
            }
            $input['images'] = json_encode($imgs);
        }

        if (@$input['features'] && @$input['features'] != null) {
            $input['features'] = implode(',', $input['features']);
        }

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        // dd($input);
        $record->fill($input);
        $record->save();
        // dd($record);
        if ($record->save()) {
            return redirect(route('admin.doctor.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.doctor.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Doctor $page)
    {
        //
    }

    public function edit(Request $request, Doctor $doctor)
    {
        if (@$doctor->features && @$doctor->features != null) {
            $doctor->features = explode(',', $doctor->features);
        }

        $page = $doctor;
        $editData =  $doctor->toArray();
        $request->replace($editData);
        $request->flash();

        $category = Category::get();
        $categoryArr  = ['' => 'Select category'];
        if (!$category->isEmpty()) {
            foreach ($category as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }
        $availableArr  = [
            'true' => 'In-Stock',
            'false' => 'Out-Stock'
        ];
        $featureArr  = [
            'top' => 'Top Doctor',
            'feature' => 'Feature Doctor',
            'new' => 'New Arrivals',
        ];

        $data = compact('page', 'categoryArr', 'doctor', 'availableArr', 'featureArr');
        return view('backend.inc.doctor.edit', $data);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $record     = $doctor;
        $input      = $request->except('_token', '_method');
        $input['field'] = $request->field ? $request->field : '{"name":[],"value":[]}';

        // if ($request->hasFile('images')) {
        //     $files = $request->file('images');
        //     $imgs = [];
        //     // dd(json_decode($page->images));
        //     foreach (json_decode($doctor->images) as $key => $v) {
        //         $imgs[] = $v;
        //     }
        //     // $imgs = $page->images;
        //     foreach ($files as $f) {
        //         $optimizeImage = Image::make($f);
        //         $optimizePath = public_path() . '/images/doctor/imgs/';
        //         if (!file_exists($optimizePath)) {
        //             mkdir($optimizePath, 0755, true);
        //         }
        //         $image = explode(".", $f->getClientOriginalName());
        //         $image_name = $image[0];
        //         $name = time() . Str::slug($image_name, '-') . '.' . $f->getClientOriginalExtension();
        //         $optimizeImage->save($optimizePath . $name, 72);
        //         $imgs[] = $name;
        //     }
        //     $input['images'] = $imgs;
        // }

        if (@$input['features'] && @$input['features'] != null) {
            $input['features'] = implode(',', $input['features']);
        } else {
            $input['features'] = '';
        }

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.doctor.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect(route('admin.doctor.index'))->with('success', 'Success! Record has been deleted');
    }

    public function page_image($page, $key)
    {
        $page = Doctor::find($page);
        $images = json_decode($page->images);
        unlink('public/images/doctor/imgs/' . $images[$key]);
        unset($images[$key]);
        $img = [];
        foreach ($images as $key => $value) {
            $img[] = $value;
        }
        $page->images = $img;
        $page->save();
        return redirect()->back()->with('success', 'Success! Image has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Doctor::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.doctor.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/doctor/';
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
        $path = public_path() . '/images/doctor/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }

    public function multi_image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/doctor/imgs/';
            if (!file_exists($optimizePath)) {
                mkdir($optimizePath, 0755, true);
            }
            $name    = time() . '' . rand(10000, 99999) . '.' . $file->extension();
            $optimizeImage->save($optimizePath . $name, 72);
        }

        return response()->json(['success' => $name]);
    }

    public function multi_image_delete(Request $request)
    {
        $filename =  $request->get('filename');
        $path = public_path() . '/images/doctor/imgs/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
