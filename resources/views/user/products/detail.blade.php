<!-- resources/views/user/products/detail.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">Detail Product</h1>
    </div>

    <!-- Product Details Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <!-- Image Carousel -->
                <div id="productCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->image_url) }}" class="d-block w-100" alt="Product Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Product Details -->
                <h2>{{ $product->name }}</h2>
                <p><b>Stock:</b> {{ $product->stock }}</p>
                <p><b>Harga:</b> Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                <p><b>Description:</b> {{ $product->description }}</p>

                <!-- Add to Cart Form -->
                
                <form action="{{ route('cart.store', ['product' => $product->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
@endsection
