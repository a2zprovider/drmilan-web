<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.faq.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.faq.index');
    }

    public function create()
    {
        return view('backend.inc.faq.add');
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

        $record           = new Faq;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.faq.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.faq.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Faq $faq)
    {
        //
    }

    public function edit(Request $request, Faq $faq)
    {
        $editData =  $faq->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('faq');
        return view('backend.inc.faq.edit', $data);
    }

    public function update(Request $request, Faq $faq)
    {
        $record     = $faq;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.faq.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect(route('admin.faq.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Faq::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.faq.index'))->with('success', 'Success! Record has been deleted');
    }

}
