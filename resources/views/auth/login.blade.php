@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 450px; padding: 20px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Login</h2>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email field -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" id="email" required autofocus>
                </div>

                <!-- Password field -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" id="password" required>
                </div>

                <!-- Remember Me checkbox -->
                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Your Password?</a>
            </div>
        </div>
    </div>
</div>
@endsection
