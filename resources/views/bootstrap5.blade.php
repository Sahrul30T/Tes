<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iK7l5i5ehoibZBsUWt5I9UqOO+5YFZBvGFqcJlDddS1HqU5zB+6T2ERnJ" crossorigin="anonymous">
    <!-- Add your additional CSS styles here -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- Your Logo -->
                <img src="path/to/your/logo.png" alt="Your Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Product</a>
                        <!-- Example of a dropdown menu -->
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Category 1</a></li>
                            <li><a class="dropdown-item" href="#">Category 2</a></li>
                            <li><a class="dropdown-item" href="#">Category 3</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cart <span class="badge badge-danger">3</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Your page content goes here -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-eKpAuTNx1wJcyw7+fK3HIgXrjsl5EMgeVfs3bx9G6eM1ZIcWHp5x7OJU5cpkN" crossorigin="anonymous"></script>
    <!-- Add your additional JavaScript scripts here -->
</body>
</html>
