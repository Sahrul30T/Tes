<!-- resources/views/user/orders/payment.blade.php -->

@extends('layouts.user-app')

@section('content')
    <!-- Hero Section -->
    <div class="hero">
        <h1 class="text-center">Payment</h1>
    </div>

    <!-- Payment Data Section -->
    <div class="container mt-4">
        <h3>Your Order:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Rp. {{ number_format($product->price * $product->pivot->quantity, 0, ',', '.') }} </td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total Amount</td>
                        <td>Rp. {{ number_format($order->total_amount , 0, ',', '.') }}</td>
                    </tr>
            </tbody>
        </table>


        <div>
            <h3>Payment Information:</h3>
            <table class="table table-responsive" width="100px">
                <tr>
                    <td>Bank</td>
                    <td>:</td>
                    <td>BSI</td>
                </tr>
                <tr>
                    <td>Account Name</td>
                    <td>:</td>
                    <td>Fathonah Fitrianti</td>
                </tr>
                <tr>
                    <td>Account Number</td>
                    <td>:</td>
                    <td>7167725718</td>
                </tr>
            </table>    
        </div>
        
        <!-- Pratinjau gambar pembayaran -->
        @if($order->payment)
            <h4>Payment Proof:</h4>
            <img id="proof" src="{{ asset('storage/' . $order->payment->proof_of_payment) }}" alt="Payment Proof" style="max-width: 300px;">
        @endif

        <!-- Form untuk mengunggah bukti pembayaran -->
        <h4>Upload Payment Proof:</h4>                
        <form action="{{ route('orders.uploadPayment', $order->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">                
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" onchange="previewPaymentProof(this);" required>

                <img id="paymentProofPreview" class="img-fluid mt-2" style="display:none; max-width: 300px;">
            </div>
            <button type="submit" class="btn btn-primary">Upload Payment Proof</button>
        </form>
    </div>

    <script>
        function previewPaymentProof(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#paymentProofPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#paymentProofPreview').hide();
            }
        }


    </script>
@endsection
