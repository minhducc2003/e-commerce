@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">All Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Orders List</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <div class="badge {{ $order->status === 'delivered' ? 'badge-outline-success' : 'badge-outline-warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.orders.deliver', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm">Mark as Delivered</button>
                                    </form>
                                    
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
