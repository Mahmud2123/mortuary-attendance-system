@extends('layouts.app')
@section('title', 'Audit Logs')

@section('content')
<h3 class="mb-4">Audit Trail</h3>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="table_name" class="form-select">
                    <option value="">All Tables</option>
                    @foreach(['bodies','chambers','users'] as $t)
                        <option value="{{ $t }}" {{ request('table_name') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    @foreach(['create','update','delete'] as $a)
                        <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>User</th><th>Action</th><th>Table</th><th>Record ID</th><th>Date</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ optional($log->user)->full_name ?? 'System' }}</td>
                    <td><span class="badge bg-{{ $log->action == 'create' ? 'success' : ($log->action == 'delete' ? 'danger' : 'warning') }}">{{ ucfirst($log->action) }}</span></td>
                    <td>{{ ucfirst($log->table_name) }}</td>
                    <td>#{{ $log->record_id }}</td>
                    <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No audit records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $logs->links() }}</div>
</div>
@endsection
