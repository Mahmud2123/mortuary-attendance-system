@extends('layouts.app')
@section('title', 'New Staff Account')

@section('content')
<h3 class="mb-4">New Staff Account</h3>
<div class="card"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required></div>
            <div class="col-md-6"><label class="form-label">Staff ID *</label><input type="text" name="staff_id" class="form-control" value="{{ old('staff_id') }}" required></div>
            <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
            <div class="col-md-6"><label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    <option value="attendant">Attendant</option>
                    <option value="management">Management</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="col-md-6"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required minlength="8"></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Account</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
