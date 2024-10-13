@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            @if($product->image_path)
                <img src="{{ asset('storage/products/' . $product->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/300" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1 class="mb-4">{{ $product->name }}</h1>
            <h3 class="text-success mb-3">Price: ${{ number_format($product->price, 2) }}</h3>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            
            <form action="{{ route('cart.add') }}" method="POST" class="d-inline mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="number" name="quantity" value="1" min="1" class="form-control" aria-label="Quantity">
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </div>
            </form>
            
            <a href="{{ route('user.cart') }}" class="btn btn-primary btn-lg mt-3">View Cart</a>
        </div>
    </div>
</div>
@endsection
