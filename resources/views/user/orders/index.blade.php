@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        <a href="{{ route('user.order', $order->id) }}" class="btn btn-info">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
