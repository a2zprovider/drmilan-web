<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogcategory;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blogcategory::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.blogcategory.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.blogcategory.index');
    }

    public function create()
    {
        $categories = Blogcategory::get();
        $categoryArr  = ['' => 'Select parent category'];
        if (!$categories->isEmpty()) {
            foreach ($categories as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }

        $data = compact('categoryArr');
        return view('backend.inc.blogcategory.add', $data);
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

        $record           = new Blogcategory;
        $input            = $request->except('_token');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.blogcategory.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.blogcategory.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Blogcategory $blogcategory)
    {
        //
    }

    public function edit(Request $request, Blogcategory $blogcategory)
    {
        $editData =  $blogcategory->toArray();
        $request->replace($editData);
        $request->flash();


        $categories = Blogcategory::get();
        $categoryArr  = ['' => 'Select parent category'];
        if (!$categories->isEmpty()) {
            foreach ($categories as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }

        $data = compact('blogcategory', 'categoryArr');
        return view('backend.inc.blogcategory.edit', $data);
    }

    public function update(Request $request, Blogcategory $blogcategory)
    {
        $record     = $blogcategory;
        $input      = $request->except('_token', '_method');
       
        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.blogcategory.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Blogcategory $blogcategory)
    {
        $blogcategory->delete();
        return redirect(route('admin.blogcategory.index'))->with('success', 'Success! Record has been deleted');
    }
    
    public function deleteAll(Request $request)
    {
        $objs = Blogcategory::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.blogcategory.index'))->with('success', 'Success! Record has been deleted');
    }
    
    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/blogcategory/';
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
        $path = public_path() . '/images/blogcategory/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
