<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.country.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.inc.country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.inc.country.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string',
        ];

        $messages = [
            'name'  => 'Please Enter Name.',
        ];

        $request->validate($rules, $messages);

        $record           = new Country;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.country.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.country.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(Country $country)
    {
        //
    }

    public function edit(Request $request, Country $country)
    {
        $editData =  $country->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('country');
        return view('backend.inc.country.edit', $data);
    }

    public function update(Request $request, Country $country)
    {
        $record     = $country;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.country.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect(route('admin.country.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = Country::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.country.index'))->with('success', 'Success! Record has been deleted');
    }
}
