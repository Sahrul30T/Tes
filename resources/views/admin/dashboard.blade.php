@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Card Jumlah Pesanan Baru -->
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pesanan Baru</h5>
                        <p class="card-text">{{ $newOrdersCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Jumlah Pesanan Selesai -->
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pesanan Selesai</h5>
                        <p class="card-text">{{ $completedOrdersCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Jumlah Produk -->
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Produk</h5>
                        <p class="card-text">{{ $productsCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
