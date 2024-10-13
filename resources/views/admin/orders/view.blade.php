@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Order Details</h1>

    <div class="card mt-4 shadow">
        <div class="card-body">
            <h5 class="card-title">Order ID: <span class="text-primary">{{ $order->id }}</span></h5>
            <p class="card-text"><strong>User:</strong> {{ $order->user->name }}</p>
            <p class="card-text"><strong>Total Amount:</strong> <span class="text-success">${{ number_format($order->total_amount, 2) }}</span></p>
            <p class="card-text"><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Status:</strong> 
                <span class="badge bg-{{ $order->status == 'Delivered' ? 'success' : ($order->status == 'Pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>

            <h5 class="mt-4">Order Items</h5>
            <ul class="list-group mb-3">
                @foreach($order->orderItems as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>{{ $item->product->name }}</strong>
                        <span>${{ number_format($item->price, 2) }} (x{{ $item->quantity }})</span>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mt-3">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
