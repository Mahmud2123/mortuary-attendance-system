@extends('layouts.app')
@section('title', 'Edit Staff Account')

@section('content')
<h3 class="mb-4">Edit Staff — {{ $user->full_name }}</h3>
<div class="card"><div class="card-body">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required></div>
            <div class="col-md-6"><label class="form-label">Staff ID *</label><input type="text" name="staff_id" class="form-control" value="{{ old('staff_id', $user->staff_id) }}" required></div>
            <div class="col-md-6"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
            <div class="col-md-3"><label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    @foreach(['attendant','management','admin'] as $r)
                        <option value="{{ $r }}" {{ $user->role == $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"><label class="form-label">Status *</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-6"><label class="form-label">New Password</label><input type="password" name="password" class="form-control" minlength="8" placeholder="Leave blank to keep current"></div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Account</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div></div>
@endsection
