<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Galary;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalaryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Galary::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->type == 'home') {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.galary.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    } else {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.galary.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.galary.index');
    }

    public function create()
    {
        return view('backend.inc.galary.add');
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

        $record           = new Galary;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.galary.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.galary.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Galary $galary)
    {
        //
    }

    public function edit(Request $request, Galary $galary)
    {
        $editData =  $galary->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('galary');
        return view('backend.inc.galary.edit', $data);
    }

    public function update(Request $request, Galary $galary)
    {
        $record     = $galary;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.galary.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Galary $galary)
    {
        $galary->delete();
        return redirect(route('admin.galary.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Galary::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.galary.index'))->with('success', 'Success! Record has been deleted');
    }

    public function meta_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Galary::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.meta.galary.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.meta.galary.index');
    }

    public function meta_edit(Request $request, Galary $galary)
    {
        $editData =  $galary->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('galary');
        return view('backend.inc.meta.galary.edit', $data);
    }

    public function meta_update(Request $request, Galary $galary)
    {
        $record     = $galary;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.meta.galary.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/galary/';
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
        $path = public_path() . '/images/galary/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
