<!-- resources/views/admin/products/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="products-tab" data-toggle="tab" href="#products">Data Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories">Data Category</a>
            </li>
        </ul>

        <div class="tab-content mt-2">
            <!-- Tab Produk -->
            <div class="tab-pane fade show active" id="products">  
                <div class="mt-3 mb-3">  
                    <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                        <i class="fas fa-upload"></i>
                        + Tambah Produk Baru
                    </a> 
                </div> 
                
                <table id="productsTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Berat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Isi tabel akan diisi melalui JavaScript (Datatables) -->
                    </tbody>
                </table>            
            </div>

            <!-- Tab Category -->
            <div class="tab-pane fade" id="categories">    
                <div class="mt-3 mb-3">  
                    <a class="btn btn-success" href="{{ route('admin.categories.create') }}">
                        <i class="fas fa-upload"></i>
                        + Tambah Kategori Baru
                    </a> 
                </div>                         
                <table id="categoriesTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Isi tabel akan diisi melalui JavaScript (Datatables) -->
                    </tbody>
                </table>                     
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                // Inisialisasi DataTable untuk Data Produk
                $('#productsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.products.datatables') }}",
                    columns: [
                        { data: 'name', name: 'name' },
                        { 
                            data: 'price', 
                            name: 'price', 
                            render: function (data, type, full, meta) {
                                return 'Rp ' + formatRupiah(data);
                            }
                        },
                        { data: 'stock', name: 'stock' },
                        { data: 'category.name', name: 'category.name' },
                        { data: 'weight', name: 'weight',
                            render: function (data, type, full, meta) {
                                return data + ' gram';
                            }},
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    "scrollX": true                             
                });

                // Inisialisasi DataTable untuk Data Category
                $('#categoriesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.categories.datatables') }}",
                    columns: [
                        { data: 'name', name: 'name' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]                            
                });

                // Tambahkan event handler untuk tombol delete di setiap tabel
                $('#productsTable, #categoriesTable').on('click', '.btn-delete', function() {
                    var url = $(this).data('url');
                    var row = $(this).closest('tr');

                    var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data ini?");
                    
                    if (confirmDelete) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Hapus baris tabel setelah penghapusan berhasil
                                row.remove();
                                alert(response.message);
                            },
                            error: function(response) {
                                alert('Terjadi kesalahan saat menghapus data.');
                            }
                        });
                    }
                });
            });

            // Fungsi untuk format Rupiah
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }
        </script>
    @endpush
@endsection
