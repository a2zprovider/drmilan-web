<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->type == 'home') {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.review.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    } else {
                        $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.review.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.review.index');
    }

    public function create()
    {
        return view('backend.inc.review.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string',
            'image'  => 'required'
        ];

        $messages = [
            'record.name'  => 'Please Enter Name.',
            'image'  => 'Please Select Image'
        ];
        $request->validate($rules, $messages);

        $record           = new Review;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.review.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.review.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Review $review)
    {
        //
    }

    public function edit(Request $request, Review $review)
    {
        $editData =  $review->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('review');
        return view('backend.inc.review.edit', $data);
    }

    public function update(Request $request, Review $review)
    {
        $record     = $review;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.review.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect(route('admin.review.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Review::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.review.index'))->with('success', 'Success! Record has been deleted');
    }

    public function meta_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.meta.review.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.meta.review.index');
    }

    public function meta_edit(Request $request, Review $review)
    {
        $editData =  $review->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('review');
        return view('backend.inc.meta.review.edit', $data);
    }

    public function meta_update(Request $request, Review $review)
    {
        $record     = $review;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.meta.review.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function image_upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/review/';
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
        $path = public_path() . '/images/review/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
