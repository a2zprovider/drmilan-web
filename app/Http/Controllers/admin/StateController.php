<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = State::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.state.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('country', function ($row) {
                    return $row->country ? $row->country->name : '';
                })
                ->rawColumns(['action', 'country'])
                ->make(true);
        }

        return view('backend.inc.state.index');
    }

    public function create()
    {
        $countries = Country::get();
        $countryArr  = ['' => 'Select country'];
        if (!$countries->isEmpty()) {
            foreach ($countries as $country) {
                $countryArr[$country->id] = $country->name;
            }
        }

        $data = compact('countryArr');
        return view('backend.inc.state.add', $data);
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

        $record           = new State;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.state.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.state.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(State $state)
    {
        //
    }

    public function edit(Request $request, State $state)
    {
        $editData =  $state->toArray();
        $request->replace($editData);
        $request->flash();

        $countries = Country::get();
        $countryArr  = ['' => 'Select country'];
        if (!$countries->isEmpty()) {
            foreach ($countries as $country) {
                $countryArr[$country->id] = $country->name;
            }
        }
        $data = compact('state', 'countryArr');
        return view('backend.inc.state.edit', $data);
    }

    public function update(Request $request, State $state)
    {
        $record     = $state;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.state.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect(route('admin.state.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $objs = State::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.state.index'))->with('success', 'Success! Record has been deleted');
    }
}
