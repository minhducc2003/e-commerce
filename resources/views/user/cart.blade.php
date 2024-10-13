@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Cart</h1>
    
    @if($cartItems->isEmpty())
        <div class="alert alert-info" role="alert">
            Your cart is empty.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control me-2" style="width: 80px;">
                            <button type="submit" class="btn btn-warning btn-sm">Update</button>
                        </form>
                    </td>
                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3">Total: ${{ number_format($total, 2) }}</h3>
            <a href="{{ route('payment') }}" class="btn btn-success">Proceed to Payment</a>
        </div>
    @endif
</div>
@endsection
