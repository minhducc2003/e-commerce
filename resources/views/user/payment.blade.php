@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Payment</h1>
    <form action="{{ route('payment.complete') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="card_name">Cardholder Name</label>
            <input type="text" name="card_name" id="card_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" id="card_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="text" name="expiry_date" id="expiry_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Complete Payment</button>
    </form>
</div>
@endsection
