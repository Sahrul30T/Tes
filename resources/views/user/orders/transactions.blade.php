<!-- resources/views/user/orders/transactions.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">Transactions</h1>
    </div>

    <!-- Transactions Data Section -->
    <div class="container mt-4" style="min-height: 50vh">
        <h3>Your Transactions:</h3>
        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>                    
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->products->first()->name }}</td>
                        <td>Rp. {{ number_format($order->total_amount , 0, ',', '.') }}</td>
                        <td>                        
                            <span id="orderStatusBadge" class="badge badge-primary p-2">{{ $order->status }}</span>
                        </td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#orderDetailsModal{{ $order->id }}">
                                Detail
                            </button>

                            @if($order->status === 'new' || $order->status === 'paid')
                                <a href="{{ route('orders.payment', $order->id) }}" class="btn btn-success">Pay</a>
                            @elseif($order->status === 'shipped')
                                <button class="btn btn-info" data-toggle="modal" data-target="#completeOrderModal{{ $order->id }}">
                                    Complete Order
                                </button>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal untuk Detail Pesanan -->
                    <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModal{{ $order->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderDetailsModal{{ $order->id }}Label">Order Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h5>Information</h5>
                                            <hr>
                                            <h6>Date: {{ $order->created_at }}</h6><br>

                                            <h6>User: {{ $order->user->name }}</h6>
                                            <h6>Address: {{ $order->user->address }}</h6><br>

                                            <h6>Total Amount: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
                                            <h5>Products</h5>
                                            <hr>
                                            @foreach($order->products as $product)
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $product->name }}</h6>
                                                        <p class="card-text">
                                                            {{ $product->pivot->quantity }} x Rp {{ number_format($product->price, 0, ',', '.') }}<br>                                                            
                                                            Subtotal: Rp {{ number_format($product->pivot->quantity * $product->price, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk Menyelesaikan Pesanan -->
                    <div class="modal fade" id="completeOrderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="completeOrderModal{{ $order->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="completeOrderModal{{ $order->id }}Label">Complete Order</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to complete this order?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('orders.complete', $order->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Complete Order</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <div class="container mt-4">                    
            {{ $orders->render('pagination::bootstrap-4') }}
        </div>
    </div> 
    
    
@endsection
