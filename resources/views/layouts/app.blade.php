<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> 
    <!-- Load Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('styles')
</head>
<body class="bg-light">

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">                
                <img src="{{ asset('images/florist_logo.png') }}" alt="Section Logo" width="220">
            </div>

            <ul class="list-unstyled components">
                <!-- Menu -->
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
                </li>
                <li class="{{ Request::is('admin/products') ? 'active' : '' }}">
                    <a href="{{ url('/admin/products') }}">Data Produk</a>
                </li>
                <li class="{{ Request::is('admin/orders') ? 'active' : '' }}">
                    <a href="{{ url('/admin/orders') }}">Data Pesanan 
                        <span id="newOrdersBadge" class="badge badge-danger"></span>                                               
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/logout') }}">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <!-- Tombol untuk menutup dan membuka sidebar -->
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fa fa-align-left"></i>
                        <span>☰</span>
                    </button>

                    <!-- Isi lainnya di navbar (jika ada) -->

                </div>
            </nav>
            @yield('content')
        </div>
    </div>

    <!-- JavaScript dan jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script> <!-- Menambahkan script tambahan untuk sidebar -->
    <script>
        function updateNewOrdersBadge() {
            $.ajax({
                url: '{{ route('admin.new_orders_count') }}',
                type: 'GET',
                success: function (response) {
                    // Memperbarui nilai badge dengan jumlah pesanan baru
                    $('#newOrdersBadge').text(response.count);
                },
                error: function (error) {
                    console.error('Error fetching new orders count:', error);
                }
            });
        }

        // Panggil fungsi updateNewOrdersBadge saat halaman dimuat
        $(document).ready(function () {
            updateNewOrdersBadge();
        });
    </script>
    @stack('scripts')
</body>
</html>
