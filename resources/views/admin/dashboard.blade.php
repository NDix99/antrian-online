<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            height: calc(100vh - 56px);
        }
        .content {
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .nav-pills .nav-link {
            color: #495057;
        }
        .nav-pills .nav-link.active {
            background-color: #28a745;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">RSUD CARUBAN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link"><i class="bi bi-geo-alt"></i> Jl. A. Yani KM 2 Caruban, MADIUN</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link"><i class="bi bi-telephone"></i> 0351-383956</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link"><i class="bi bi-envelope"></i> rsudcaruban@madiunkab.go.id</span>
                </li>
                <li class="nav-item">
                    <span class="nav-link"><i class="bi bi-clock"></i> <span id="currentDateTime"></span></span>
                </li>
                <script>
                    function updateDateTime() {
                        const now = new Date();
                        const options = { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric', 
                            hour: '2-digit', 
                            minute: '2-digit', 
                            second: '2-digit', 
                            hour12: false, 
                            timeZone: 'Asia/Jakarta' 
                        };
                        document.getElementById('currentDateTime').textContent = now.toLocaleString('id-ID', options) + ' WIB';
                    }
                    updateDateTime();
                    setInterval(updateDateTime, 1000);
                </script>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout <i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar pt-3">
            <ul class="nav flex-column nav-pills">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.setting') }}"><i class="bi bi-gear"></i> Settings</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.user') }}"><i class="bi bi-people"></i> Users</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-list-ol"></i> Data Antrian</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-display"></i> Display Antrian</a>
                </li>
            </ul>
        </div>

        <div class="col-md-10 content">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Selamat Datang, <strong>Admin!</strong></h3>
                    <p class="card-text">Pada halaman ini, Anda dapat mengelola berbagai pengaturan dan konfigurasi untuk website Antrian Online RSUD Caruban. Fitur-fitur yang tersedia meliputi:</p>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item"><i class="bi bi-toggle-on text-success me-2"></i> Mengaktifkan atau menonaktifkan fitur input di halaman utama</li>
                        <li class="list-group-item"><i class="bi bi-calendar-event text-primary me-2"></i> Menambah atau menghapus hari libur layanan dan informasi terkait</li>
                        <li class="list-group-item"><i class="bi bi-123 text-warning me-2"></i> Mengubah pengaturan nomor antrian</li>
                        <li class="list-group-item"><i class="bi bi-shield-lock text-danger me-2"></i> Mengatur hak akses pengguna</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
