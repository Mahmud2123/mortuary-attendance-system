@extends('layouts.app')
@section('title', 'Chamber Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">{{ $chamber->name }}</h3>
    @if(auth()->user()->isAdmin())
    <form method="POST" action="{{ route('chambers.destroy', $chamber) }}" onsubmit="return confirm('Delete this chamber?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger" {{ $chamber->current_occupancy > 0 ? 'disabled' : '' }}><i class="bi bi-trash"></i> Delete</button>
    </form>
    @endif
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card bg-secondary-soft"><i class="bi bi-geo-alt"></i><div><h5 class="mb-0">{{ $chamber->location }}</h5><p>Location</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-info-soft"><i class="bi bi-grid"></i><div><h3>{{ $chamber->capacity }}</h3><p>Capacity</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-warning-soft"><i class="bi bi-box"></i><div><h3>{{ $chamber->current_occupancy }}</h3><p>Occupied</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-{{ $chamber->status_color }}-soft"><i class="bi bi-info-circle"></i><div><h5 class="mb-0">{{ ucfirst($chamber->status) }}</h5><p>Status</p></div></div></div>
</div>

<div class="card">
    <div class="card-header"><strong>Bodies Currently in This Chamber</strong></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Ref Number</th><th>Name</th><th>Date of Death</th><th></th></tr></thead>
            <tbody>
                @forelse($chamber->bodies as $body)
                <tr>
                    <td>{{ $body->ref_number }}</td>
                    <td>{{ $body->full_name }}</td>
                    <td>{{ optional($body->date_of_death)->format('d M Y') }}</td>
                    <td><a href="{{ route('bodies.show', $body) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No bodies currently stored in this chamber.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
