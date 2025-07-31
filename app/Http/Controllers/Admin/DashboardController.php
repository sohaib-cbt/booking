<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Team;
use App\Models\Group;
use App\Models\School;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Therapist;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all bookings and group counts
        $bookingCounts = Booking::whereIn('status', ['archive', 'active'])->get()->groupBy('status')->map->count();

        // Latest 5 bookings
        $latestBookings = Booking::latest()->take(5)->get();

        // Count all other entities
        $schools = School::count();
        $therapist  = Therapist::count();
        $groups  = Group::count();
        $rooms   = Room::count();
        $teams   = Team::count();

        return view('admin.dashboard', compact(
            'bookingCounts',
            'latestBookings',
            'schools',
            'therapist',
            'rooms',
            'teams',
            'groups',
        ));
    }

    public function booking_chart_data()
    {
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $bookings = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw("SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_count"),
            DB::raw("SUM(CASE WHEN status = 'archive' THEN 1 ELSE 0 END) as archive_count")
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Fill missing dates with 0
        $dates = [];
        $active = [];
        $archive = [];

        $period = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate->addDay());
        foreach ($period as $date) {
            $day = $date->format('Y-m-d');
            $found = $bookings->firstWhere('date', $day);
            $dates[] = $date->format('M d');
            $active[] = $found ? (int)$found->active_count : 0;
            $archive[] = $found ? (int)$found->archive_count : 0;
        }

        return response()->json([
            'dates' => $dates,
            'active' => $active,
            'archive' => $archive,
        ]);
    }
}
