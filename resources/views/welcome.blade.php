<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSUD Caruban Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            <form>
                <div class="mb-3">
                    <label for="nomorRM" class="form-label"><i class="fas fa-id-card me-2"></i>Nomor Rekam Medis:</label>
                    <input type="text" class="form-control form-control-lg" id="nomorRM" name="nomorRM" placeholder="Isikan No. RM Anda">
                    <div id="nomorRMFeedback" class="invalid-feedback" style="display: none;">
                        Nomor Rekam Medis belum terdaftar.
                    </div>
                </div>
                <script>
                    document.getElementById('nomorRM').addEventListener('blur', function() {
                        // Simulate database check (replace with actual AJAX call to your backend)
                        setTimeout(() => {
                            const isValid = Math.random() < 0.5; // 50% chance of being valid
                            const feedbackElement = document.getElementById('nomorRMFeedback');
                            if (!isValid) {
                                this.classList.add('is-invalid');
                                feedbackElement.style.display = 'block';
                            } else {
                                this.classList.remove('is-invalid');
                                feedbackElement.style.display = 'none';
                            }
                        }, 500);
                    });
                </script>
                <div class="mb-3">
                    <label for="tanggalKunjungan" class="form-label"><i class="far fa-calendar-check me-2"></i>Pilih Tanggal Kunjungan (3 hari ke depan):</label>
                    <input type="date" class="form-control form-control-lg" id="tanggalKunjungan">
                </div>
                <div class="text-center">
                    <button type="button" id="ambilAntrianBtn" class="btn btn-success btn-lg mt-3"><i class="fas fa-check-circle me-2"></i>Ambil Antrian</button>
                </div>
                <script>
                    document.getElementById('ambilAntrianBtn').addEventListener('click', function() {
                        const nomorRM = document.getElementById('nomorRM').value;
                        const tanggalKunjungan = document.getElementById('tanggalKunjungan').value;
                        
                        if (!nomorRM || !tanggalKunjungan) {
                            alert('isi nen no rekam medis e suu!!');
                            return;
                        }

                        // Kirim permintaan ke server untuk mengambil nomor antrian
                        fetch('/ambil-antrian', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                nomorRM: nomorRM,
                                tanggalKunjungan: tanggalKunjungan
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(`Nomor antrian Anda: ${data.nomorAntrian}`);
                                // Tambahkan logika lain jika diperlukan, seperti memperbarui tampilan
                            } else {
                                alert(data.message || 'Terjadi kesalahan saat mengambil nomor antrian.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi nanti.');
                        });
                    });
                </script>
            </form>
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
