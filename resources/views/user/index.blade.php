@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($product->image_path)
                        <img src="{{ asset('storage/products/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <div class="mt-auto">
                            <a href="{{ url('/product', $product->id) }}" class="btn btn-primary">View Details</a>
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1" class="form-control d-inline" style="width: 70px;">
                                <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
