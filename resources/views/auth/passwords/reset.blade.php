@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reset Password</h1>

    <form action="{{ route('password.reset') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email field -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <!-- Password field -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <!-- Confirm Password field -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection
