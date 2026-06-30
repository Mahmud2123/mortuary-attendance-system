@extends('layouts.app')
@section('title', 'Bodies')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Body Records</h3>
    @if(auth()->user()->isAdmin() || auth()->user()->isAttendant())
        <a href="{{ route('bodies.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Admission</a>
    @endif
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or ref number" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['admitted','in_storage','released','transferred'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="{{ request('from') }}" title="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" class="form-control" value="{{ request('to') }}" title="To date">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Ref Number</th><th>Name</th><th>Age</th><th>Sex</th><th>Chamber</th><th>Status</th><th>Admitted</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($bodies as $body)
                <tr>
                    <td>{{ $body->ref_number }}</td>
                    <td>{{ $body->full_name }}</td>
                    <td>{{ $body->age ?? '-' }}</td>
                    <td>{{ ucfirst($body->sex) }}</td>
                    <td>{{ optional($body->chamber)->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $body->status_badge }}">{{ ucfirst(str_replace('_',' ', $body->status)) }}</span></td>
                    <td>{{ $body->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('bodies.show', $body) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No body records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $bodies->links() }}</div>
</div>
@endsection
