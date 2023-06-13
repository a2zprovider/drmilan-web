<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.tag.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.tag.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.inc.tag.add');
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

        $record           = new Tag;
        $input            = $request->except('_token');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.tag.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.tag.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Tag $tag)
    {
        //
    }

    public function edit(Request $request, Tag $tag)
    {
        $editData =  $tag->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('tag');
        return view('backend.inc.tag.edit', $data);
    }

    public function update(Request $request, Tag $tag)
    {
        $record     = $tag;
        $input      = $request->except('_token', '_method');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.tag.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('admin.tag.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Tag::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.tag.index'))->with('success', 'Success! Record has been deleted');
    }
}
