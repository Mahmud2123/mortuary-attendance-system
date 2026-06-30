@extends('layouts.app')
@section('title', 'New Admission')

@section('content')
<h3 class="mb-4">New Body Admission</h3>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bodies.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="{{ old('age') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sex *</label>
                    <select name="sex" class="form-select" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nationality *</label>
                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Nigerian') }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Death</label>
                    <input type="date" name="date_of_death" class="form-control" value="{{ old('date_of_death') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time of Death</label>
                    <input type="time" name="time_of_death" class="form-control" value="{{ old('time_of_death') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Chamber Assignment</label>
                    <select name="chamber_id" class="form-select">
                        <option value="">-- Not Assigned Yet --</option>
                        @foreach($chambers as $chamber)
                            <option value="{{ $chamber->id }}">{{ $chamber->name }} ({{ $chamber->getAvailableSlots() }} slots free)</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cause of Death</label>
                    <input type="text" name="cause_of_death" class="form-control" value="{{ old('cause_of_death') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Place of Death</label>
                    <input type="text" name="place_of_death" class="form-control" value="{{ old('place_of_death') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Admission</button>
                <a href="{{ route('bodies.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
