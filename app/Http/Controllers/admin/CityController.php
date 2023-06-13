<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = City::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.city.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('state', function ($row) {
                    return $row->state ? $row->state->name : '';
                })
                ->rawColumns(['action', 'state'])
                ->make(true);
        }

        return view('backend.inc.city.index');
    }

    public function create()
    {
        $states = State::get();
        $stateArr  = ['' => 'Select state'];
        if (!$states->isEmpty()) {
            foreach ($states as $state) {
                $stateArr[$state->id] = $state->name;
            }
        }

        $data = compact('stateArr');
        return view('backend.inc.city.add', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string',
        ];

        $messages = [
            'name'  => 'Please Enter Name.',
        ];

        $request->validate($rules, $messages);

        $record           = new City;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.city.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.city.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(City $city)
    {
        //
    }

    public function edit(Request $request, City $city)
    {
        $editData =  $city->toArray();
        $request->replace($editData);
        $request->flash();

        $states = State::get();
        $stateArr  = ['' => 'Select state'];
        if (!$states->isEmpty()) {
            foreach ($states as $state) {
                $stateArr[$state->id] = $state->name;
            }
        }
        $data = compact('city', 'stateArr');
        return view('backend.inc.city.edit', $data);
    }

    public function update(Request $request, City $city)
    {
        $record     = $city;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.city.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect(route('admin.city.index'))->with('success', 'Success! Record has been deleted');
    }
    public function deleteAll(Request $request)
    {
        $objs = City::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.city.index'))->with('success', 'Success! Record has been deleted');
    }
}
