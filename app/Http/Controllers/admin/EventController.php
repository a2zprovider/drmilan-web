<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->type == 'home') {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.event.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    } else {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.event.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.event.index');
    }

    public function create()
    {
        return view('backend.inc.event.add');
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

        $record           = new Event;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.event.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.event.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Event $event)
    {
        //
    }

    public function edit(Request $request, Event $event)
    {
        $editData =  $event->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('event');
        return view('backend.inc.event.edit', $data);
    }

    public function update(Request $request, Event $event)
    {
        $record     = $event;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.event.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect(route('admin.event.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Event::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.event.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/event/';
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
        $path = public_path() . '/images/event/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
