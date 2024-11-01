<!-- resources/views/user/home.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/carousel1.png') }}" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/carousel2.png') }}" class="d-block w-100" alt="Slide 2">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Best Sellers Section -->
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Best Sellers</h2>
        <div class="row">
            @foreach($bestSellers as $product)            
                <div class="col-md-3">
                    <div class="card">
                        @if(count($product->images))
                            <img src="{{ asset('storage/' . $product->images[0]->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>

                            <p class="card-text">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
            @endforeach            
        </div>
    </div>
@endsection
