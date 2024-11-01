<!-- resources/views/admin/products.blade.php -->

@extends('layouts.app')

@section('title', 'Admin Products')

@section('content')
    <div class="container mt-4">
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="true">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
                <table class="table" id="productsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Product data will be populated dynamically using DataTable -->
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                <table class="table" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Category data will be populated dynamically using DataTable -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize DataTable for Products
                $('#productsTable').DataTable({
                    // Add your DataTable options here
                    ajax: {
                        url: '{{ route('admin.products.data') }}', // Replace with your route for fetching product data
                        type: 'GET',
                    },
                    columns: [
                        { data: 'name' },
                        { data: 'price' },
                        { data: 'stock' },
                        { data: 'weight' },
                    ],
                });

                // Initialize DataTable for Categories
                $('#categoriesTable').DataTable({
                    // Add your DataTable options here
                    ajax: {
                        url: '{{ route('admin.categories.data') }}', // Replace with your route for fetching category data
                        type: 'GET',                        
                    },
                    columns: [
                        { data: 'name' },
                    ],
                });
            });
        </script>
    @endpush
@endsection
