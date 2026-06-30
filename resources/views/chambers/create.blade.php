@extends('layouts.app')
@section('title', 'New Chamber')

@section('content')
<h3 class="mb-4">New Chamber</h3>
<div class="card"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('chambers.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Name *</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
            <div class="col-md-6"><label class="form-label">Location *</label><input type="text" name="location" class="form-control" value="{{ old('location') }}" required></div>
            <div class="col-md-6"><label class="form-label">Capacity *</label><input type="number" name="capacity" min="1" class="form-control" value="{{ old('capacity', 1) }}" required></div>
            <div class="col-md-6"><label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    <option value="available">Available</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control">{{ old('notes') }}</textarea></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Chamber</button>
            <a href="{{ route('chambers.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
