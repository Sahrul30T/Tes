<!-- resources/views/layouts/user-app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautiful Florist</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> 
    <!-- Add your additional CSS styles here -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.home') }}">
                <!-- Your Logo -->
                <img src="{{ asset('images/florist_logo.png') }}" alt="Your Logo" height="72">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProduct" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Product
                        </a>
                        <!-- Example of a dropdown menu -->
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownProduct">
                            <a class="dropdown-item" href="{{ route('products.index') }}">All Products</a>
                            <div class="dropdown-divider"></div>
                            
                        </div>
                    </li>
                    <!-- Updated login and register buttons -->
                    @guest
                        <li class="nav-item">
                            <a class=" btn btn-success" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                            &nbsp
                            <a class=" btn btn-primary" href="{{ route('user.register') }}">Register</a>
                        </li>                        
                    @else
                        <!-- Display user's name with dropdown menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <!-- Add dropdown menu items for user actions (e.g., logout) -->
                                <a class="dropdown-item" href="{{ route('user.edit') }}" >Edit User Data</a>
                                <a class="dropdown-item" href="{{ route('orders.transactions') }}" >Transactions</a>
                                <a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <!-- Updated cart button with badge -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                Cart <span id="cart-badge" class="badge badge-danger">0</span>
                            </a>
                        </li>
                    @endguest                    
                </ul>
            </div>
        </div>
    </nav>

    <!-- Your page content goes here -->
    <div class="container-fluid mb-3" style="padding: 0">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif        

        @yield('content')
    </div>

    <footer class="bg-secondary text-light py-4">
        <div class="container text-center">
            &copy; 2023 Beautiful Florist
        </div>
    </footer>
    

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Add your login form content here -->
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulir Login -->
                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>                        

                        <button type="submit" class="btn btn-primary mt-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Kode JavaScript -->
    <script>
        $(document).ready(function() {
            // Mengambil data kategori saat halaman dimuat
            $.ajax({
                url: '/categories',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Proses data kategori yang diterima
                    var categories = response.categories;

                    // Lakukan sesuatu dengan data kategori, misalnya membangun menu navigasi
                    buildNavigationMenu(categories);
                },
                error: function(error) {
                    console.error('Error fetching categories:', error);
                }
            });

            // Fungsi untuk membangun menu navigasi
            function buildNavigationMenu(categories) {
                // Menambahkan kategori ke dalam dropdown menu
                var dropdownMenu = $('#navbarDropdownProduct + .dropdown-menu');
                dropdownMenu.empty();

                // Menambahkan item "All Products"
                dropdownMenu.append('<a class="dropdown-item" href="{{ route("products.index") }}">All Products</a>');
                dropdownMenu.append('<div class="dropdown-divider"></div>');

                // Menambahkan item kategori
                for (var i = 0; i < categories.length; i++) {
                    var category = categories[i];
                    dropdownMenu.append('<a class="dropdown-item" href="{{ route("products.index") }}?category=' + category.id + '">' + category.name + '</a>');
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengambil dan memperbarui nilai badge
            function updateCartBadge() {
                $.ajax({
                    url: '/cart/count',
                    type: 'GET',
                    success: function(response) {
                        $('#cart-badge').text(response.count);
                    },
                    error: function(error) {
                        console.log('Error updating cart badge:', error);
                    }
                });
            }

            // Panggil fungsi untuk pertama kali halaman dimuat
            updateCartBadge();
        });
    </script>     
</body>
</html>
