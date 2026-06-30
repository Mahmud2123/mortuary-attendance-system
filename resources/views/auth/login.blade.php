@extends('layouts.guest')
@section('title', 'Login')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Sign In</button>
</form>

<div class="mt-4 p-3 bg-light rounded small">
    <strong>Demo Accounts</strong> (password: <code>password</code>)
    <ul class="mb-0 mt-2 ps-3">
        <li>Admin: admin@mortuary.ng</li>
        <li>Attendant: fatima@mortuary.ng</li>
        <li>Management: mgmt@mortuary.ng</li>
    </ul>
</div>
@endsection
