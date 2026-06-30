@extends('layouts.app')
@section('title', 'Staff Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Staff Management</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Staff Account</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Staff ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->staff_id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary text-uppercase">{{ $user->role }}</span></td>
                    <td><span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span></td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        @if($user->id !== auth()->id() && $user->status === 'active')
                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Deactivate this account?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Deactivate</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $users->links() }}</div>
</div>
@endsection
