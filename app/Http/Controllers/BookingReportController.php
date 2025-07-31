<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Group;
use App\Models\School;
use App\Models\Booking;
use App\Models\Therapist;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BookingReportController extends Controller
{
    public function booking_reports()
    {
        $existingGroups = Group::get();
        $therapists = Therapist::get();
        $schools = School::get();
        return view('admin.booking.reports', compact('existingGroups', 'therapists', 'schools'));
        // $bookings = Booking::orderBy('id', 'desc')->get();
    }
    public function get_booking_reports(Request $request)
    {
        if ($request->ajax()) {
            $query = Booking::with('groups', 'contacts')
                ->orderBy('id', 'desc');
            // Apply filters
            if ($request->filled('status')) {
                $query->whereHas('contacts', function ($q) use ($request) {
                    $q->where('contact_type', $request->status);
                });
            }
            if ($request->filled('therapist')) {
                $query->where('therapist_id', $request->therapist);
            }
            if ($request->filled('client_name')) {
                $query->where('client_name', 'like', '%' . $request->client_name . '%');
            }
            if ($request->filled('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }
            if ($request->filled('archive')) {
                $query->where('status', $request->archive);
            } else {
                $query->where('status', 'active');
            }
            if ($request->filled('type')) {
                $query->where('booking_form_type', $request->type);
            }
            if ($request->filled('school_id')) {
                $query->where('school_id', $request->school_id);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('group_name', fn($row) => $row->groups->first()->title ?? 'N/A')

                ->addColumn('added', fn($row) => $row->created_at ? $row->created_at->format('Y-m-d h:i A') : 'N/A')
                ->addColumn('last_change', fn($row) => $row->updated_at ? $row->updated_at->format('Y-m-d h:i A') : 'N/A')
                ->addColumn('status', fn($row) => $row->status == 'active' ? '<span class="badge badge-light-success">Active</span>' : '<span class="badge badge-light-danger">Archive</span>')

                ->rawColumns(['group_name', 'status'])
                ->make(true);
        }
        return abort(404);
    }
    public function downloadReport(Request $request)
    {
        $fileName = Carbon::now()->format('d-M-Y h-i A') . '_Report.xlsx';
        return Excel::download(new ReportsExport($request->all()), $fileName);
    }
}
