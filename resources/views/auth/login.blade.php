<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - RSUD Caruban</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid">
    <!-- Header Section -->
    <nav class="navbar navbar-light bg-success text-white">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">RUMAH SAKIT UMUM DAERAH CARUBAN</a>
            <p class="mb-0 text-white">Jl. A. Yani KM 2 Caruban, MADIUN | Phone: 0351-383956 | Email: rsudcaruban@madiunkab.go.id</p>
            <div>
                <p class="mb-0 text-white"><i class="bi bi-clock"></i> 10 Oktober 2024 pukul 14.13 WIB</p>
            </div>
        </div>
    </nav>
    <!-- End of Header -->

    <!-- Login Form Section -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4>Login Admin</h4>
                </div>
                <div class="card-body">
                    <form action="/login" method="POST">
                        <!-- Add CSRF Token if using Laravel -->
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group mb-3">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-block">Login <i class="bi bi-box-arrow-in-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Login Form Section -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
