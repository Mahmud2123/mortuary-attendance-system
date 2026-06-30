<?php

namespace App\Http\Controllers;

use App\Models\Body;
use App\Models\AttendanceLog;
use App\Models\Chamber;
use App\Models\BodyRelease;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function admissions(Request $request)
    {
        $query = Body::with('admittedBy', 'chamber');
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->from);
        if ($request->filled('to'))   $query->whereDate('created_at', '<=', $request->to);
        if ($request->filled('status')) $query->where('status', $request->status);

        $bodies = $query->latest()->get();

        if ($request->format === 'csv') {
            return $this->csvResponse($bodies, 'admissions-report.csv', [
                'Ref Number','Full Name','Age','Sex','Date of Death','Status','Chamber','Admitted By','Admitted On'
            ], fn($b) => [
                $b->ref_number, $b->full_name, $b->age, $b->sex,
                optional($b->date_of_death)->format('Y-m-d'), $b->status,
                optional($b->chamber)->name ?? '-', optional($b->admittedBy)->full_name,
                $b->created_at->format('Y-m-d H:i'),
            ]);
        }

        $pdf = \PDF::loadView('reports.admissions-pdf', compact('bodies'));
        return $pdf->download('admissions-report.pdf');
    }

    public function attendance(Request $request)
    {
        $query = AttendanceLog::with('staff');
        if ($request->filled('staff_id')) $query->where('staff_id', $request->staff_id);
        if ($request->filled('from')) $query->whereDate('clock_in', '>=', $request->from);
        if ($request->filled('to'))   $query->whereDate('clock_in', '<=', $request->to);

        $logs = $query->latest('clock_in')->get();

        if ($request->format === 'csv') {
            return $this->csvResponse($logs, 'attendance-report.csv', [
                'Staff Name','Staff ID','Clock In','Clock Out','Duration (Hours)'
            ], fn($l) => [
                optional($l->staff)->full_name, optional($l->staff)->staff_id,
                $l->clock_in->format('Y-m-d H:i'),
                optional($l->clock_out)->format('Y-m-d H:i') ?? 'Active',
                $l->duration_hours ?? '-',
            ]);
        }

        $pdf = \PDF::loadView('reports.attendance-pdf', compact('logs'));
        return $pdf->download('attendance-report.pdf');
    }

    public function chambers(Request $request)
    {
        $chambers = Chamber::withCount('bodies')->get();

        if ($request->format === 'csv') {
            return $this->csvResponse($chambers, 'chamber-occupancy-report.csv', [
                'Name','Location','Capacity','Current Occupancy','Status'
            ], fn($c) => [$c->name, $c->location, $c->capacity, $c->current_occupancy, $c->status]);
        }

        $pdf = \PDF::loadView('reports.chambers-pdf', compact('chambers'));
        return $pdf->download('chamber-occupancy-report.pdf');
    }

    public function releases(Request $request)
    {
        $query = BodyRelease::with('body', 'releasedBy', 'kin');
        if ($request->filled('from')) $query->whereDate('release_date', '>=', $request->from);
        if ($request->filled('to'))   $query->whereDate('release_date', '<=', $request->to);

        $releases = $query->latest('release_date')->get();

        if ($request->format === 'csv') {
            return $this->csvResponse($releases, 'releases-report.csv', [
                'Ref Number','Deceased Name','Released To','Relationship','Released By','Release Date'
            ], fn($r) => [
                optional($r->body)->ref_number, optional($r->body)->full_name,
                optional($r->kin)->full_name, optional($r->kin)->relationship,
                optional($r->releasedBy)->full_name, $r->release_date->format('Y-m-d'),
            ]);
        }

        $pdf = \PDF::loadView('reports.releases-pdf', compact('releases'));
        return $pdf->download('releases-report.pdf');
    }

    private function csvResponse($rows, string $filename, array $headers, callable $mapRow): StreamedResponse
    {
        return response()->streamDownload(function () use ($rows, $headers, $mapRow) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            foreach ($rows as $row) {
                fputcsv($out, $mapRow($row));
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
