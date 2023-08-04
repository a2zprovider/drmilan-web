<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Appointment::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('doctor', function ($row) {
                    $date = $row->doctor->name;
                    return $date;
                })
                ->addColumn('date', function ($row) {
                    $date = $row->date;
                    return $date;
                })
                ->addColumn('created_at', function ($row) {
                    $date = $row->created_at;
                    return $date;
                })
                ->rawColumns(['doctor', 'date', 'created_at'])
                ->make(true);
        }

        return view('backend.inc.appointment.index');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect(route('admin.appointment.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $inquiries = Appointment::whereIn('id', $request->ids_arr)->get();
        foreach ($inquiries as $key => $inq) {
            $inq->delete();
        }
        return redirect(route('admin.appointment.index'))->with('success', 'Success! Record has been deleted');
    }
}
