@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Register</h2>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required autofocus>
                </div>

                <!-- Email field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>

                <!-- Password field -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>

                <!-- Confirm Password field -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="btn btn-link">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
