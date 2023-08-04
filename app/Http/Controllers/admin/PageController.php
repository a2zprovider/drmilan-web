<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Page::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.page.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.page.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.page.index');
    }

    public function create()
    {
        return view('backend.inc.page.add');
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

        $record           = new Page;
        $input            = $request->except('_token');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.page.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.page.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Page $page)
    {
        //
    }

    public function edit(Request $request, Page $page)
    {
        $editData =  $page->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('page');
        return view('backend.inc.page.edit', $data);
    }

    public function update(Request $request, Page $page)
    {
        $record     = $page;
        $input      = $request->except('_token', '_method');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.page.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Page $page)
    {
        if ($page->type == 'page') {
            $page->delete();
        }
        return redirect(route('admin.page.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Page::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            if ($obj->type == 'page') {
                $obj->delete();
            }
        }
        return redirect(route('admin.page.index'))->with('success', 'Success! Record has been deleted');
    }

    public function meta_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Page::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.meta.page.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.meta.page.index');
    }

    public function meta_edit(Request $request, Page $page)
    {
        $editData =  $page->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('page');
        return view('backend.inc.meta.page.edit', $data);
    }

    public function meta_update(Request $request, Page $page)
    {
        $record     = $page;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.meta.page.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/page/';
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
        $path = public_path() . '/images/page/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
