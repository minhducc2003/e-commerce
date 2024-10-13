@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item) <!-- Assuming Order has a relation to OrderItem -->
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Amount: ${{ number_format($order->total_amount, 2) }}</h3>
    <p>Status: {{ ucfirst($order->status) }}</p>
    <a href="{{ route('user.orders') }}" class="btn btn-secondary">Back to Orders</a>
</div>
@endsection
