<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Inquiry::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    $date = $row->created_at;
                    return $date;
                })
                ->rawColumns(['date'])
                ->make(true);
        }

        return view('backend.inc.inquiry.index');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect(route('admin.inquiry.index'))->with('success', 'Success! Record has been deleted');
    }

    public function deleteAll(Request $request)
    {
        $inquiries = Inquiry::whereIn('id', $request->ids_arr)->get();
        foreach ($inquiries as $key => $inq) {
            $inq->delete();
        }
        return redirect(route('admin.inquiry.index'))->with('success', 'Success! Record has been deleted');
    }

    public function newsletter(Request $request)
    {
        if ($request->ajax()) {
            $data = Newsletter::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    $date = $row->created_at;
                    return $date;
                })
                ->rawColumns(['date'])
                ->make(true);
        }

        return view('backend.inc.newsletter.index');
    }
}
