<!-- resources/views/admin/products/create.blade.php -->

@extends('layouts.app')

@section('content-title', 'Upload Data Produk')

@section('content')
    <div class="container mt-4 mb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h3 style="text-align: center">Upload Data Produk</h3>

        <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            
            <div class="row">
                <div class="form-group col">
                    <label for="price">Harga:</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>

                <div class="form-group col">
                    <label for="stock">Stok:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="weight">Berat (Gram):</label>
                    <input type="number" class="form-control" id="weight" name="weight" required>
                </div>

                <div class="form-group col">
                    <label for="category">Kategori:</label>
                    <select class="form-control" id="category" name="category" required>
                        <!-- List Category -->
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="images">Gambar Produk (maksimal 5):</label>
                <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple>
                <div id="image-preview-container" class="mt-2"></div>
            </div>            

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    @push('scripts')
        <script>
            // Tampilkan pratinjau gambar sebelum diupload
            document.getElementById('images').addEventListener('change', function (e) {
                const container = document.getElementById('image-preview-container');
                container.innerHTML = ''; // Hapus pratinjau yang sudah ada

                // Loop melalui file yang dipilih
                for (const file of e.target.files) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Tampilkan pratinjau gambar
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail mr-2';
                        img.width = 100; // Sesuaikan dengan ukuran yang diinginkan
                        container.appendChild(img);
                    };

                    // Baca file sebagai URL data
                    reader.readAsDataURL(file);
                }
            });
            
        </script>
    @endpush
@endsection
