<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Medicine::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->appointment->name;
                })
                ->addColumn('mobile', function ($row) {
                    return $row->appointment->mobile;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    $btn = '<img src="images/medicine/' . $row->image . '" width="40" height="40" style="object-fit:contain;">';
                    return $btn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('backend.inc.medicine.index');
    }

    public function create()
    {
        return view('backend.inc.medicine.add');
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

        $record           = new Medicine();
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.medicine.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.medicine.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Medicine $medicine)
    {
        //
    }

    public function edit(Request $request, Medicine $medicine)
    {
        $editData =  $medicine->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('medicine');
        return view('backend.inc.medicine.edit', $data);
    }

    public function update(Request $request, Medicine $medicine)
    {
        $record     = $medicine;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.medicine.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect(route('admin.medicine.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Medicine::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.medicine.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/medicine/';
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
        $path = public_path() . '/images/medicine/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
