<!-- resources/views/admin/orders/details.blade.php -->

<!-- Detail Pesanan -->
<div class="row mb-3">
    <div class="col-md-6">
        <h5>Data Pesanan</h5>
        <table class="table">
            <tr>
                <th>Nama User</th>
                <td>{{ $order->user->name }}</td>
            </tr>
            <tr>
                <th>Alamat User</th>
                <td>{{ $order->user->address }}</td>
            </tr>
            <tr>
                <th>Tanggal Order</th>
                <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>            
            <!-- Tambahan data pesanan, seperti shipping cost dan total -->
        </table>
        
    </div>
    <div class="col-md-6">
        <h5>Detail Produk</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Quantity</th>
                    <th>Harga Produk</th>
                    <th>Total Pesanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($product->pivot->quantity * $product->price, 0, ',', '.') }} </td>
                    </tr>
                @endforeach                    
                    <tr>
                        <th>Total Pesanan</th>
                        <td></td>
                        <td></td>                        
                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }} </td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div class="col" style="text-align:center">
        @if ($order->status == 'paid')
            <h5>Bukti Pembayaran:</h5>
            <img src="{{ asset('storage/' . $order->payment->proof_of_payment) }}" alt="Payment Proof" class="img" width="200px">

            <div class="mt-2">
                <form action="{{ route('admin.orders.approvePayment', $order->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success">Terima Pembayaran</button>
                </form>
            </div>
        @endif
        @if ($order->status == 'processed')
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning">Kirim Pesanan</button>
            </form>
        @endif
    </div>
</div>