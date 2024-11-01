<!-- resources/views/user/products/index.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">List Product</h1>
    </div>
    <div class="container mt-4">
        <div class="row">
            <!-- Filter Section -->
            <div class="col-md-3">
                <form action="{{ route('products.index') }}" method="get">
                    <div class="form-group">
                        <label for="category">Filter by Category:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="" {{ is_null($selectedCategory) ? 'selected' : '' }}>All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>
            </div>

            <!-- Product List Section -->
            <div class="col-md-9">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $product->images[0]->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>                                    
                                    <p class="card-text">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="card-text">Stok: {{ $product->stock }}</p>
                                    <a href="{{ route('products.show', ['id' => $product->id]) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="container mt-4">                    
                    {{ $products->render('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>    
@endsection
