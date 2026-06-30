<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceLog::with('staff');

        if (!auth()->user()->isAdmin() && !auth()->user()->isManagement()) {
            $query->where('staff_id', auth()->id());
        } elseif ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('clock_in', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('clock_in', '<=', $request->to);
        }

        $logs  = $query->latest('clock_in')->paginate(20)->withQueryString();
        $staff = User::whereIn('role', ['attendant', 'admin'])->get();
        $myActive = auth()->user()->currentAttendance();

        return view('attendance.index', compact('logs', 'staff', 'myActive'));
    }

    public function clockIn()
    {
        $active = auth()->user()->currentAttendance();
        if ($active) {
            return back()->with('error', 'You are already clocked in.');
        }

        AttendanceLog::create([
            'staff_id' => auth()->id(),
            'clock_in' => now(),
        ]);

        return back()->with('success', 'Clocked in successfully at ' . now()->format('h:i A'));
    }

    public function clockOut()
    {
        $active = auth()->user()->currentAttendance();
        if (!$active) {
            return back()->with('error', 'You have no active clock-in session.');
        }

        $clockOut = now();
        $hours = $active->clock_in->diffInMinutes($clockOut) / 60;

        $active->update([
            'clock_out'      => $clockOut,
            'duration_hours' => round($hours, 2),
        ]);

        return back()->with('success', 'Clocked out successfully at ' . $clockOut->format('h:i A'));
    }
}
