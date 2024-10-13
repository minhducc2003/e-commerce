@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New User</h1>
    
    <form action="{{ route('admin.accounts.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ url('/admin/accounts') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
