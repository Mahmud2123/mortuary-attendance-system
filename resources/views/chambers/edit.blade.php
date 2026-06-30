@extends('layouts.app')
@section('title', 'Edit Chamber')

@section('content')
<h3 class="mb-4">Edit Chamber — {{ $chamber->name }}</h3>
<div class="card"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('chambers.update', $chamber) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" value="{{ old('name', $chamber->name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Location *</label><input type="text" name="location" class="form-control" value="{{ old('location', $chamber->location) }}" required></div>
            <div class="col-md-6"><label class="form-label">Capacity *</label><input type="number" name="capacity" min="{{ $chamber->current_occupancy }}" class="form-control" value="{{ old('capacity', $chamber->capacity) }}" required></div>
            <div class="col-md-6"><label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    @foreach(['available','full','maintenance'] as $s)
                        <option value="{{ $s }}" {{ $chamber->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control">{{ old('notes', $chamber->notes) }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Chamber</button>
            <a href="{{ route('chambers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
