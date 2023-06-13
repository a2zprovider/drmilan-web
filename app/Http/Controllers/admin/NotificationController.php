<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Notification::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.notification.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.notification.index');
    }

    public function create()
    {
        return view('backend.inc.notification.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'title'  => 'required|string',
        ];

        $messages = [
            'title'  => 'Please Enter Title.',
        ];

        $request->validate($rules, $messages);

        $record           = new Notification;
        $input            = $request->except('_token');
        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.notification.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.notification.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Notification $notification)
    {
        //
    }

    public function edit(Request $request, Notification $notification)
    {
        $editData =  $notification->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('notification');
        return view('backend.inc.notification.edit', $data);
    }

    public function update(Request $request, Notification $notification)
    {
        $record     = $notification;
        $input      = $request->except('_token', '_method');
        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.notification.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect(route('admin.notification.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Notification::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.notification.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/notification/';
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
        $path = public_path() . '/images/notification/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
