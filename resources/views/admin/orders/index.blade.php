<!-- resources/views/admin/orders/index.blade.php -->

@extends('layouts.app')

@section('content-title', 'Data Pesanan')

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h2>Data Pesanan</h2>

        <ul class="nav nav-tabs" id="orderTabs">
            <li class="nav-item">
                <a class="nav-link active" id="newOrderTab" data-toggle="tab" href="#newOrder">Pesanan Baru</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="paidOrderTab" data-toggle="tab" href="#paidOrder">Sudah Bayar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="processedOrderTab" data-toggle="tab" href="#processedOrder">Diproses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="shippedOrderTab" data-toggle="tab" href="#shippedOrder">Dikirim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completedOrderTab" data-toggle="tab" href="#completedOrder">Selesai</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="newOrder">
                @include('admin.orders.partials.order_table', ['status' => 'new', 'orders' => $newOrders])
            </div>
            <div class="tab-pane fade" id="paidOrder">
                @include('admin.orders.partials.order_table', ['status' => 'paid', 'orders' => $paidOrders])
            </div>
            <div class="tab-pane fade" id="processedOrder">
                @include('admin.orders.partials.order_table', ['status' => 'processed', 'orders' => $processedOrders])
            </div>
            <div class="tab-pane fade" id="shippedOrder">
                @include('admin.orders.partials.order_table', ['status' => 'shipped', 'orders' => $shippedOrders])
            </div>
            <div class="tab-pane fade" id="completedOrder">
                @include('admin.orders.partials.order_table', ['status' => 'completed', 'orders' => $completedOrders])
            </div>
        </div>
    </div>

    <!-- Add this modal code at the end of the file, before the closing </body> tag -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content of the modal will be filled dynamically with JavaScript -->
                    <div id="orderDetailContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')        
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script>
            // Function to show order details in the modal
            function showOrderDetail(orderId) {
                // Make an AJAX request to fetch order details
                $.ajax({
                    url: "{{ route('admin.orders.details') }}",
                    type: 'GET',
                    data: { orderId: orderId },
                    success: function(response) {
                        // Update modal content with order details
                        $('#orderDetailContent').html(response);

                        // // Show the modal
                        $('#orderDetailModal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        </script>
    @endpush
@endsection
