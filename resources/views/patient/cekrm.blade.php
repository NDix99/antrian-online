<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Caruban - Cek Nomor Rekam Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background-color: #1a8039;
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card {
            margin: 30px 0;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .alert-custom {
            background-color: #e7f5ff;
            border-left: 5px solid #0d6efd;
            padding: 20px;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #1a8039;
            border: none;
        }
        .btn-primary:hover {
            background-color: #146c2e;
        }
        .form-control:focus {
            border-color: #1a8039;
            box-shadow: 0 0 0 0.2rem rgba(26, 128, 57, 0.25);
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <div class="header text-center mb-4">
            <h1><i class="fas fa-hospital-alt me-2"></i>RUMAH SAKIT UMUM DAERAH CARUBAN</h1>
            <p><i class="fas fa-map-marker-alt me-2"></i>Jl. A. Yani KM 2 Caruban, MADIUN | <i class="fas fa-phone me-2"></i>0351-383956 | <i class="fas fa-envelope me-2"></i>rsudcaruban@madiunkab.go.id</p>
        </div>
        
        <div class="container">
            <!-- Information Alert -->
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-custom">
                        <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i><strong>Mohon diperhatikan</strong></h4>
                        <ol>
                            <li>Pastikan bahwa anda sudah terdaftar dan mempunyai Nomor Rekam Medis di RSUD Caruban.</li>
                            <li>Pastikan nomor NIK (KTP) anda sudah sesuai dengan data diri anda.</li>
                            <li>Bagi Pasien baru / belum memiliki Nomor Rekam Medis di RSUD Caruban diharapkan melakukan pendaftaran di tempat.</li>
                        </ol>
                        <a href="{{ url('/') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Utama</a>
                    </div>
                </div>
            </div>

            <!-- Medical Record Number Check Form -->
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4"><i class="fas fa-search me-2"></i>Cek Nomor Rekam Medis</h3>
                    <form id="checkRMForm" onsubmit="checkRM(event)">
                        @csrf
                        <div class="mb-4">
                            <label for="nik" class="form-label"><i class="fas fa-id-card me-2"></i>Ketikkan NIK Anda</label>
                            <input type="text" class="form-control form-control-lg" id="nik" name="nik" placeholder="Masukkan 16 digit NIK Anda" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-check-circle me-2"></i>Cek Nomor RM</button>
                        </div>
                    </form>

                    <!-- Tambahkan div untuk menampilkan hasil -->
                    <div id="result" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h5 class="alert-heading">Hasil Pencarian:</h5>
                            <p id="rmResult"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function checkRM(event) {
        event.preventDefault();
        
        $.ajax({
            url: '{{ route("check.rm") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nik: $('#nik').val()
            },
            success: function(response) {
                if(response.success) {
                    $('#rmResult').html(`NIK: ${response.patient.nik}<br>Nama: ${response.patient.nama}<br>Nomor RM: ${response.patient.no_rm}`);
                    $('#result').show();
                } else {
                    $('#rmResult').html(response.message);
                    $('#result').show();
                }
            },
            error: function() {
                $('#rmResult').html('Terjadi kesalahan. Silakan coba lagi.');
                $('#result').show();
            }
        });
    }
    </script>
</body>
</html>
