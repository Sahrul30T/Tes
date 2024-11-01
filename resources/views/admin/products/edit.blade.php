<!-- resources/views/admin/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4 mb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h3 style="text-align: center">Edit Data Produk</h3>

        <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="price">Harga:</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                </div>

                <div class="form-group col">
                    <label for="stock">Stok:</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="weight">Berat:</label>
                    <input type="number" class="form-control" id="weight" name="weight" value="{{ $product->weight }}" required>
                </div>

                <div class="form-group col">
                    <label for="category_id">Kategori:</label>
                    <select class="form-control" id="category" name="category" required>
                    <!-- Populate this dropdown with category options from your database -->
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                </div>            
            </div>

            <div class="form-group">
                <label for="existing_images">Gambar Saat Ini:</label>
                <div id="existing-images" class="d-flex flex-wrap">
                    @foreach($product->images as $image)
                        <div class="mr-2 mb-2">
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product Image" class="img-thumbnail">
                            <button type="button" class="btn btn-sm btn-danger btn-delete-image" data-image-id="{{ $image->id }}" onclick="removeImage(this, {{ $image->id }})">Hapus</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="images">Tambah Gambar (maksimal 5):</label>
                <input type="file" class="form-control-file" id="images" name="images[]" accept="image/*" multiple>
                <div id="image-preview-container" class="mt-2"></div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    @push('scripts')
        <script>            
            // Fungsi untuk menampilkan preview gambar
            function previewImages() {
                var previewContainer = document.getElementById('existing-images');
                var files = document.getElementById('images').files;

                previewContainer.innerHTML = '';

                for (var i = 0; i < files.length && i < 5; i++) {
                    var file = files[i];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var img = document.createElement('img');
                        img.className = 'img-thumbnail mr-2 mb-2';
                        img.width = 400; // Sesuaikan dengan ukuran yang diinginkan
                        img.src = e.target.result;

                        previewContainer.appendChild(img);
                    }

                    reader.readAsDataURL(file);
                }
            }

            function removeImage(button, imageId) {
                // Hapus gambar dari tampilan
                button.parentNode.remove();

                // Buat input tersembunyi untuk menyimpan ID gambar yang akan dihapus
                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'deleted_images[]';
                hiddenInput.value = imageId;
                document.querySelector('form').appendChild(hiddenInput);
            }

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
