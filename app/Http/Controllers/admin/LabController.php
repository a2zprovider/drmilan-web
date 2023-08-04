<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class LabController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Lab::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.lab.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.lab.index');
    }

    public function create()
    {
        return view('backend.inc.lab.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string',
        ];

        $messages = [
            'name'  => 'Please Enter Name.',
        ];

        $request->validate($rules, $messages);

        $record           = new Lab;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.lab.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.lab.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Lab $lab)
    {
        //
    }

    public function edit(Request $request, Lab $lab)
    {
        $editData =  $lab->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('lab');
        return view('backend.inc.lab.edit', $data);
    }

    public function update(Request $request, Lab $lab)
    {
        $record     = $lab;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.lab.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Lab $lab)
    {
        $lab->delete();

        return redirect(route('admin.lab.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Lab::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.lab.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/lab/';
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
        $path = public_path() . '/images/lab/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
