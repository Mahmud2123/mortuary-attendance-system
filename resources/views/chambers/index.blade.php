@extends('layouts.app')
@section('title', 'Chambers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Cold Storage Chambers</h3>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('chambers.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Chamber</a>
    @endif
</div>

<div class="row g-3">
    @foreach($chambers as $chamber)
    <div class="col-md-4 col-lg-3">
        <div class="card chamber-card border-{{ $chamber->status_color }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h5>{{ $chamber->name }}</h5>
                    <span class="badge bg-{{ $chamber->status_color }}">{{ ucfirst($chamber->status) }}</span>
                </div>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> {{ $chamber->location }}</p>
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-{{ $chamber->status_color }}" style="width: {{ $chamber->occupancy_percent }}%"></div>
                </div>
                <p class="mb-3">{{ $chamber->current_occupancy }} / {{ $chamber->capacity }} occupied</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('chambers.show', $chamber) }}" class="btn btn-sm btn-outline-primary flex-fill">View</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('chambers.edit', $chamber) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
