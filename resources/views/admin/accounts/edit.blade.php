@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Account</h1>

    <form action="{{ url('/admin/accounts/' . $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Account Details</h5>

                <!-- Name input -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                </div>

                <!-- Email input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                </div>

                <!-- Role selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" id="role" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Password input (optional update) -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>

                <!-- Confirm Password input (optional update) -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">Update Account</button>
                <a href="{{ url('/admin/accounts') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
