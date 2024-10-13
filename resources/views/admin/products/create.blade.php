@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create Product</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product Information</h5>

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" class="form-control-file" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
