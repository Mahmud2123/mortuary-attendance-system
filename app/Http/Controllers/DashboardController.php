<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\Chamber;
use App\Models\AttendanceLog;
use App\Models\BodyRelease;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_bodies'      => Body::count(),
            'in_storage'        => Body::where('status', 'in_storage')->count(),
            'admitted_today'    => Body::whereDate('created_at', $today)->count(),
            'released_today'    => BodyRelease::whereDate('release_date', $today)->count(),
            'total_chambers'    => Chamber::count(),
            'available_chambers'=> Chamber::where('status', 'available')->count(),
            'staff_on_duty'     => AttendanceLog::whereNull('clock_out')->count(),
        ];

        $chambers     = Chamber::all();
        $recentBodies = Body::with('admittedBy', 'chamber')->latest()->take(8)->get();

        // 30-day admissions vs releases chart data
        $chartLabels  = [];
        $admissions   = [];
        $releases     = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $admissions[]  = Body::whereDate('created_at', $date)->count();
            $releases[]    = BodyRelease::whereDate('release_date', $date)->count();
        }

        // Status distribution
        $statusCounts = [
            Body::where('status', 'admitted')->count(),
            Body::where('status', 'in_storage')->count(),
            Body::where('status', 'released')->count(),
            Body::where('status', 'transferred')->count(),
        ];

        return view('dashboard.index', compact(
            'stats', 'chambers', 'recentBodies',
            'chartLabels', 'admissions', 'releases', 'statusCounts'
        ));
    }
}
