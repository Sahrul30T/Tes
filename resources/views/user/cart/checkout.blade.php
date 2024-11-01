<!-- resources/views/user/cart/checkout.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">Checkout</h1>
    </div>

    <!-- Checkout Data Section -->
    <div class="container mt-4">        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}

                @if(session('editAddress'))
                    <br>
                    <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Address</a>
                @endif
            </div>
        @endif
        
        <h4>Your Information:</h4>
        <p>Name: {{ Auth::user()->name }}</p>
        <p>No: {{ Auth::user()->no }}</p>
        <p>Address: {{ Auth::user()->address }}</p>

        <h4>Your Cart:</h4>
        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->products as $product)
                    <tr>
                        <td><img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" style="max-width: 150px;"></td>
                        <td>{{ $product->name }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Rp. {{ number_format($product->price * $product->pivot->quantity , 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <h4>Payment Method:</h4>
        <p>Bank Transfer</p>

        <h4 class="mt-md-3">Total Price: Rp. {{ number_format($totalPrice , 0, ',', '.') }}</h4>

        <div class="text-right mt-3">
            <form action="{{ route('cart.processCheckout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">Place Order</button>
            </form>
        </div>
    </div>
@endsection
