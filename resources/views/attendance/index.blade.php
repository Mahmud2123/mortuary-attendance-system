@extends('layouts.app')
@section('title', 'Attendance')

@section('content')
<h3 class="mb-4">Staff Attendance</h3>

<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="mb-1">Your Clock Status</h5>
            @if($myActive)
                <p class="mb-0 text-success"><i class="bi bi-circle-fill"></i> Clocked in since {{ $myActive->clock_in->format('h:i A, d M Y') }}</p>
            @else
                <p class="mb-0 text-muted"><i class="bi bi-circle"></i> Not currently clocked in</p>
            @endif
        </div>
        <div class="d-flex gap-2">
            <form method="POST" action="{{ route('attendance.clock-in') }}">
                @csrf
                <button class="btn btn-success" {{ $myActive ? 'disabled' : '' }}><i class="bi bi-box-arrow-in-right"></i> Clock In</button>
            </form>
            <form method="POST" action="{{ route('attendance.clock-out') }}">
                @csrf
                <button class="btn btn-danger" {{ !$myActive ? 'disabled' : '' }}><i class="bi bi-box-arrow-left"></i> Clock Out</button>
            </form>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin() || auth()->user()->isManagement())
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="staff_id" class="form-select">
                    <option value="">All Staff</option>
                    @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ request('staff_id') == $s->id ? 'selected' : '' }}>{{ $s->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
            <div class="col-md-3"><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
            <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header"><strong>Attendance History</strong></div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Staff</th><th>Clock In</th><th>Clock Out</th><th>Duration</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ optional($log->staff)->full_name }}</td>
                    <td>{{ $log->clock_in->format('d M Y, h:i A') }}</td>
                    <td>{{ optional($log->clock_out)->format('d M Y, h:i A') ?? 'Active' }}</td>
                    <td>{{ $log->duration_hours ? $log->duration_hours . ' hrs' : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No attendance records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $logs->links() }}</div>
</div>
@endsection
