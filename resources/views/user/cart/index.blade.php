<!-- resources/views/user/cart/index.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">Cart</h1>
    </div>

    <!-- Cart Data Section -->
    <div class="container mt-4" style="min-height:45vh">
        @if($cart->products->count() > 0)
            <table class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->products as $product)
                        <tr>                            
                            <td><img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" style="max-width: 200px;"></td>
                            <td>{{ $product->name }}</td>
                            <td>Rp. {{ number_format($product->price, 0, ',', '.') }} </td>
                            <td>
                                <form action="{{ route('cart.update', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="number" name="quantity" class="form-control" value="{{ $product->pivot->quantity }}" min="1">
                                    <button type="submit" class="btn btn-primary btn-sm mt-1">Update</button>
                                </form>
                            </td>
                            <td>Rp. {{ number_format($product->price * $product->pivot->quantity , 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <h4>Total: Rp. {{ number_format( $cart->products->sum(function ($product) { return $product->price * $product->pivot->quantity; }), 0, ',', '.') }}</h4>
            </div>

            <div class="text-right mt-3">
                <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
