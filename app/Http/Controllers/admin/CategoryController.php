<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.category.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.category.index');
    }

    public function create()
    {
        $categories = Category::get();
        $categoryArr  = ['' => 'Select parent category'];
        if (!$categories->isEmpty()) {
            foreach ($categories as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }

        $data = compact('categoryArr');
        return view('backend.inc.category.add', $data);
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

        $record           = new Category;
        $input            = $request->except('_token');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.category.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.category.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Request $request, Category $category)
    {
        $editData =  $category->toArray();
        $request->replace($editData);
        $request->flash();


        $categories = Category::get();
        $categoryArr  = ['' => 'Select parent category'];
        if (!$categories->isEmpty()) {
            foreach ($categories as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }

        $data = compact('category', 'categoryArr');
        return view('backend.inc.category.edit', $data);
    }

    public function update(Request $request, Category $category)
    {
        $record     = $category;
        $input      = $request->except('_token', '_method');

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.category.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('admin.category.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Category::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.category.index'))->with('success', 'Success! Record has been deleted');
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/category/';
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
        $path = public_path() . '/images/category/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
