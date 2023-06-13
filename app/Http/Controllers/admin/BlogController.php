<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.blog.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('category', function ($row) {
                    if (@$row->category_id && @$row->category_id != null && @$row->category_id != '') {
                        $row->category_id = explode(',', $row->category_id);
                    } else {
                        $row->category_id = [];
                    }
                    $pros = Blogcategory::whereIn('id', $row->category_id)->get();
                    $cat = [];
                    foreach ($pros as $key => $pro) {
                        $cat[] = $pro ? $pro->title : '';
                    }
                    $cat = implode(', ', $cat);
                    return $cat;
                })
                ->addColumn('tag', function ($row) {
                    if (@$row->tags && @$row->tags != null && @$row->tags != '') {
                        $row->tags = explode(',', $row->tags);
                    } else {
                        $row->tags = [];
                    }
                    $pros = Tag::whereIn('id', $row->tags)->get();
                    $ta = [];
                    foreach ($pros as $key => $pro) {
                        $ta[] = $pro ? $pro->title : '';
                    }
                    $ta = implode(', ', $ta);
                    return $ta;
                })
                ->rawColumns(['action', 'category', 'tag'])
                ->make(true);
        }

        return view('backend.inc.blog.index');
    }

    public function create()
    {
        $category = Blogcategory::get();
        $categoryArr  = [];
        if (!$category->isEmpty()) {
            foreach ($category as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }
        $tags = Tag::get();
        $tagArr  = [];
        if (!$tags->isEmpty()) {
            foreach ($tags as $tag) {
                $tagArr[$tag->id] = $tag->title;
            }
        }

        $data = compact('tagArr', 'categoryArr');
        return view('backend.inc.blog.add', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'  => 'required|string',
            'image'  => 'required'
        ];

        $messages = [
            'title'  => 'Please Enter Name.',
        ];

        $request->validate($rules, $messages);

        $record           = new Blog;
        $input            = $request->except('_token');

        if (@$input['category_id'] && @$input['category_id'] != null) {
            $input['category_id'] = implode(',', $input['category_id']);
        }
        if (@$input['tags'] && @$input['tags'] != null) {
            $input['tags'] = implode(',', $input['tags']);
        }

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.blog.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.blog.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Blog $page)
    {
        //
    }

    public function edit(Request $request, Blog $blog)
    {
        if (@$blog->category_id && @$blog->category_id != null) {
            $blog->category_id = explode(',', $blog->category_id);
        }
        if (@$blog->tags && @$blog->tags != null) {
            $blog->tags = explode(',', $blog->tags);
        }

        $page = $blog;
        $editData =  $blog->toArray();
        $request->replace($editData);
        $request->flash();

        $category = Blogcategory::get();
        $categoryArr  = [];
        if (!$category->isEmpty()) {
            foreach ($category as $pcat) {
                $categoryArr[$pcat->id] = $pcat->title;
            }
        }
        $tags = Tag::get();
        $tagArr  = [];
        if (!$tags->isEmpty()) {
            foreach ($tags as $tag) {
                $tagArr[$tag->id] = $tag->title;
            }
        }

        $data = compact('blog', 'tagArr', 'categoryArr');
        return view('backend.inc.blog.edit', $data);
    }

    public function update(Request $request, Blog $blog)
    {
        $record     = $blog;
        $input      = $request->except('_token', '_method');

        if (@$input['category_id'] && @$input['category_id'] != null) {
            $input['category_id'] = implode(',', $input['category_id']);
        } else {
            $input['category_id'] = '';
        }
        if (@$input['tags'] && @$input['tags'] != null) {
            $input['tags'] = implode(',', $input['tags']);
        } else {
            $input['tags'] = '';
        }

        $input['slug']    = $input['slug'] == '' ? Str::slug($input['title'], '-') : Str::slug($input['slug'], '-');
        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.blog.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect(route('admin.blog.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Blog::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.blog.index'))->with('success', 'Success! Record has been deleted');
    }


    public function meta_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.meta.blog.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.meta.blog.index');
    }

    public function meta_edit(Request $request, Blog $blog)
    {
        $page = $blog;
        $editData =  $blog->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('blog');
        return view('backend.inc.meta.blog.edit', $data);
    }

    public function meta_update(Request $request, Blog $blog)
    {
        $record     = $blog;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.meta.blog.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/blog/';
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
        $path = public_path() . '/images/blog/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
