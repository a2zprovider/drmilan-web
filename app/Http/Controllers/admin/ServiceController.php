<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->type == 'home') {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.service.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    } else {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.service.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.service.index');
    }

    public function create()
    {
        return view('backend.inc.service.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'title'  => 'required|string',
        ];

        $messages = [
            'title'  => 'Please Enter Name.',
        ];

        $request->validate($rules, $messages);

        $record           = new Service;
        $input            = $request->except('_token');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.service.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.service.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Service $service)
    {
        //
    }

    public function edit(Request $request, Service $service)
    {
        $editData =  $service->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('service');
        return view('backend.inc.service.edit', $data);
    }

    public function update(Request $request, Service $service)
    {
        $record     = $service;
        $input      = $request->except('_token', '_method');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.service.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect(route('admin.service.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Service::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.service.index'))->with('success', 'Success! Record has been deleted');
    }

    public function meta_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.meta.service.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.meta.service.index');
    }

    public function meta_edit(Request $request, Service $service)
    {
        $editData =  $service->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('service');
        return view('backend.inc.meta.service.edit', $data);
    }

    public function meta_update(Request $request, Service $service)
    {
        $record     = $service;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.meta.service.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/service/';
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
        $path = public_path() . '/images/service/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
