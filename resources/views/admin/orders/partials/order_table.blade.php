<!-- resources/views/admin/orders/partials/order_table.blade.php -->

<div class="">
    <table class="table table-striped" id="orderTable_{{ $status }}" style="width:100%">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Alamat User</th>
                <th>Produk</th>
                <th>Total Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>            
            <!-- Loop through orders based on status -->
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->user->address }}</td>
                    <td>{{ implode(', ', $order->products->pluck('name')->toArray()) }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <!-- <a href="#" class="btn btn-sm btn-info">Detail</a> -->
                        <button type="button" class="btn btn-sm btn-info" onclick="showOrderDetail({{ $order->id }})">Detail</button>
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>

@push('scripts')       
    <script>
        // Inisialisasi DataTable
        $(document).ready(function() {
            $('#orderTable_{{ $status }}').DataTable({
                "scrollX": false
            });
        });
    </script>
@endpush
