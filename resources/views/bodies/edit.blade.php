@extends('layouts.app')
@section('title', 'Edit Body Record')

@section('content')
<h3 class="mb-4">Edit Body Record — {{ $body->ref_number }}</h3>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bodies.update', $body) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $body->full_name) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="{{ old('age', $body->age) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sex *</label>
                    <select name="sex" class="form-select" required>
                        @foreach(['male','female','unknown'] as $s)
                            <option value="{{ $s }}" {{ $body->sex == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nationality *</label>
                    <input type="text" name="nationality" class="form-control" value="{{ old('nationality', $body->nationality) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Death</label>
                    <input type="date" name="date_of_death" class="form-control" value="{{ old('date_of_death', optional($body->date_of_death)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time of Death</label>
                    <input type="time" name="time_of_death" class="form-control" value="{{ old('time_of_death', $body->time_of_death) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['admitted','in_storage','released','transferred'] as $s)
                            <option value="{{ $s }}" {{ $body->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cause of Death</label>
                    <input type="text" name="cause_of_death" class="form-control" value="{{ old('cause_of_death', $body->cause_of_death) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Place of Death</label>
                    <input type="text" name="place_of_death" class="form-control" value="{{ old('place_of_death', $body->place_of_death) }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $body->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Record</button>
                <a href="{{ route('bodies.show', $body) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
