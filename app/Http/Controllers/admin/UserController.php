<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'user')->select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $sts = 'Active';
                    $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.user.status', $row->id) . '"> <i class="fas fa-check"></i> ' . $sts . '</a>';
                    if ($row->status == 'false') {
                        $sts = 'Disable';
                        $btn = '<a class="edit btn btn-danger btn-sm" href="' . route('admin.user.status', $row->id) . '"> <i class="fas fa-xmark"></i> ' . $sts . '</a>';
                    }

                    // $btn = '<a class="edit btn btn-primary btn-sm" href="' . route('admin.user.edit', $row->id) . '"> <i class="fas fa-edit"></i> Edit</a> <a href="#" class="delete btn btn-danger btn-sm" onclick="handelDelete(' . $row->id . ');return false;"><i class="fas fa-trash"></i></div>';
                    return $btn;
                })
                ->addColumn('email_verify', function ($row) {
                    $sts = 'True';
                    if ($row->email_verify == 'false') {
                        $sts = 'False';
                    }
                    return $sts;
                })
                ->rawColumns(['action', 'email_verify'])
                ->make(true);
        }

        return view('backend.inc.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.inc.user.add');
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

        $record           = new User;
        $input            = $request->except('_token');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.user.index'))->with('success', 'Success! New record has been added.');
        } else {
            return redirect(route('admin.user.index'))->with('danger', 'Error! Something going wrong.');
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(Request $request, User $user)
    {
        $editData =  $user->toArray();
        $request->replace($editData);
        $request->flash();

        $data = compact('user');
        return view('backend.inc.user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $record     = $user;
        $input      = $request->except('_token', '_method');

        $record->fill($input);
        if ($record->save()) {
            return redirect(route('admin.user.index'))->with('success', 'Success! Record has been edited');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.user.index'))->with('success', 'Success! Record has been deleted');
    }

    public function status(User $user)
    {
        if ($user->status == 'false') {
            $user->status = 'true';
        } else {
            $user->status = 'false';
        }

        $user->save();
        return redirect(route('admin.user.index'))->with('success', 'Success! Status has been changed');
    }

    public function deleteAll(Request $request)
    {
        $objs = User::whereIn('id', $request->ids_arr)->get();
        foreach ($objs as $key => $obj) {
            $obj->delete();
        }
        return redirect(route('admin.user.index'))->with('success', 'Success! Record has been deleted');
    }
}
