@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">User Accounts</h1>
    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary mb-3">Create New User</a>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Manage Users</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th> <!-- Cột số thứ tự -->
                            <th>Name</th>
                            <th>Email</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user) <!-- Thêm biến $index để lấy số thứ tự -->
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Hiển thị số thứ tự -->
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <a href="{{ route('admin.accounts.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.accounts.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
