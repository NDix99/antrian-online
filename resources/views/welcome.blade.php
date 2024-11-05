<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Caruban Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="header text-center mb-5">
        <h2><i class="fas fa-hospital-alt me-2"></i>RUMAH SAKIT UMUM DAERAH CARUBAN</h2>
        <p><i class="fas fa-map-marker-alt me-2"></i>Jl. A. Yani KM 2 Caruban, MADIUN | <i class="fas fa-phone me-2"></i>0351-383956 | <i class="fas fa-envelope me-2"></i>rsudcaruban@madiunkab.go.id</p>
        <p class="fs-5"><i class="far fa-calendar-alt me-2"></i><strong id="currentDateTime"></strong></p>
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
    </div>
    <!-- End of Header -->

    <div class="container">
        <!-- Form Section -->
        <div class="card p-4 mb-4 bg-white">
            <h3 class="card-title text-center mb-4"><i class="fas fa-ticket-alt me-2"></i>Ambil Nomor Antrian</h3>
            <form id="formAntrian" action="{{ route('antrian.ambil') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="no_rm" class="form-label"><i class="fas fa-id-card me-2"></i>Nomor Rekam Medis:</label>
                    <input type="text" class="form-control form-control-lg" id="no_rm" name="no_rm" placeholder="Isikan No. RM Anda">
                    <div id="nomorRMFeedback" class="invalid-feedback" style="display: none;">
                        Nomor Rekam Medis belum terdaftar.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tanggal_kunjungan" class="form-label"><i class="far fa-calendar-check me-2"></i>Pilih Tanggal Kunjungan (3 hari ke depan):</label>
                    <input type="date" class="form-control form-control-lg" id="tanggal_kunjungan" name="tanggal_kunjungan">
                </div>
                <script>
                    // Set batasan tanggal kunjungan
                    const tanggalKunjunganInput = document.getElementById('tanggal_kunjungan');
                    
                    // Dapatkan tanggal hari ini
                    const today = new Date();
                    
                    // Set tanggal minimum (hari ini)
                    const minDate = today.toISOString().split('T')[0];
                    tanggalKunjunganInput.setAttribute('min', minDate);
                    
                    // Set tanggal maksimum (3 hari ke depan)
                    const maxDate = new Date();
                    maxDate.setDate(today.getDate() + 3);
                    tanggalKunjunganInput.setAttribute('max', maxDate.toISOString().split('T')[0]);
                    
                    // Set default value ke hari ini
                    tanggalKunjunganInput.value = minDate;
                    
                    // Tambahkan event listener untuk validasi
                    tanggalKunjunganInput.addEventListener('change', function() {
                        const selectedDate = new Date(this.value);
                        if (selectedDate < today || selectedDate > maxDate) {
                            alert('Pilih tanggal antara hari ini dan 3 hari ke depan');
                            this.value = minDate;
                        }
                    });
                </script>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg mt-3"><i class="fas fa-check-circle me-2"></i>Ambil Antrian</button>\
                </div>
            </form>
           
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('formAntrian').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    let formData = new FormData(this);
                    
                    fetch('{{ route("antrian.ambil") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(Object.fromEntries(formData))
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Berhasil mengambil nomor antrian: ' + data.data.no_antrian);
                        } else {
                            alert('Gagal: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan');
                    });
                });
            });
            </script>
        </div>
        <!-- End of Form -->

        <!-- Terms & Conditions Section -->
        <div class="card p-4 bg-light">
            <h3 class="card-title text-center mb-4"><i class="fas fa-clipboard-list me-2"></i><strong>Syarat & Ketentuan</strong></h3>
            <ol class="fs-5">
                <li class="mb-2">Nomor pendaftaran online hanya berlaku untuk pasien yang sudah mempunyai Nomor Rekam Medis di RSUD Caruban.</li>
                <li class="mb-2">Bagi Pasien yang lupa Nomor Rekam Medis, silahkan melakukan pengecekan dengan NIK melalui menu yang tersedia dan melalui tautan berikut. <a href="{{ route('patient.cekrm') }}" class="btn btn-primary btn-sm"><i class="fas fa-search me-1"></i>CEK NOMOR REKAM MEDIS</a></li>
                <li class="mb-2">Bagi pasien baru / belum memiliki Nomor Rekam Medis di RSUD Caruban diharapkan melakukan pendaftaran di tempat.</li>
                <li class="mb-2">Pengambilan nomor antrian dibuka setiap hari, selain hari libur mulai dari H-2 sebelum tanggal kunjungan.</li>
                <li class="mb-2">Klik tombol simpan atau gunakan fitur screenshot sebagai bukti nomor antrian. 1 Nomor hanya berlaku untuk 1x sesuai tanggal kunjungan yang tertera.</li>
            </ol>
        </div>
        <!-- End of Terms -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
