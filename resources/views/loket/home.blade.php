<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RSUD Caruban Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>
</head>
<body class="bg-gray-100">  
    <div class="bg-green-700 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">RUMAH SAKIT UMUM DAERAH CARUBAN</h1>
                <p>Jl. A. Yani KM 2 Caruban, MADIUN | Phone: 0351-383956 | Email: rsudcaruban@madiunkab.go.id</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-green-800 px-4 py-2 rounded">
                    <i class="fas fa-calendar-alt"></i> <span id="currentDateTime"></span>
                </div>
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
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-white text-green-700 px-4 py-2 rounded flex items-center">
                        Logout <i class="fas fa-sign-out-alt ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="container mx-auto mt-4">
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-center">
                <a href="#" class="text-green-700 flex items-center">
                    <i class="fas fa-home mr-2"></i> Dashboard Loket Pendaftaran
                </a>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-4">
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Jumlah Antrian</h2>
                    <i class="fas fa-users text-xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2" id="totalAntrian">0</p>
            </div>
            <script>
                function updateTotalAntrian() {
                    fetch('{{ route("antrian.total") }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && typeof data.total !== 'undefined') {
                                document.getElementById('totalAntrian').textContent = data.total;
                            } else {
                                console.error('Invalid data format received');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching total:', error);
                        });
                }

                // Panggil fungsi saat halaman dimuat
                document.addEventListener('DOMContentLoaded', function() {
                    updateTotalAntrian();
                    // Update setiap 5 detik
                    setInterval(updateTotalAntrian, 10000);
                });
            </script>
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Sisa Antrian</h2>
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2" id="sisaAntrian">0</p>
            </div>
            <script>
                function updateSisaAntrian() {
                    fetch('/antrian/sisa')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && typeof data.sisa !== 'undefined') {
                                document.getElementById('sisaAntrian').textContent = data.sisa;
                            } else {
                                console.error('Invalid data format received');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching sisa antrian:', error);
                        });
                }

                // Update sisa antrian saat halaman dimuat
                document.addEventListener('DOMContentLoaded', function() {
                    updateSisaAntrian();
                    // Update setiap 10 detik
                    setInterval(updateSisaAntrian, 10000);
                });
            </script>
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Antrian Selesai</h2>
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2" id="antrianSelesai">0</p>
            </div>
            <script>
                function updateAntrianSelesai() {
                    fetch('/antrian/selesai-count')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && typeof data.total !== 'undefined') {
                                document.getElementById('antrianSelesai').textContent = data.total;
                            } else {
                                console.error('Invalid data format received');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching antrian selesai:', error);
                        });
                }

                // Update antrian selesai saat halaman dimuat
                document.addEventListener('DOMContentLoaded', function() {
                    updateAntrianSelesai();
                    // Update setiap 10 detik
                    setInterval(updateAntrianSelesai, 10000);
                });
            </script>
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Antrian Loket</h2>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                        CETAK NOMOR <i class="fas fa-file-alt ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Tabel Data Antrian</h2>
        <table id="queueTable" class="w-full">
            <thead>
                <tr>
                    <th>No. Antrian</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            let table = $('#queueTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('antrian.data') }}",
                    type: 'GET',
                    error: function (xhr, error, thrown) {
                        console.error('Error:', error);
                    }
                },
                columns: [
                    {data: 'no_antrian', name: 'no_antrian'},
                    {data: 'no_rm', name: 'no_rm'},
                    {data: 'nama', name: 'nama'},
                    {
                        data: 'tanggal_kunjungan',
                        name: 'tanggal_kunjungan',
                        render: function(data) {
                            return moment(data).format('YYYY-MM-DD HH:mm:ss');
                        }
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 10
            });

            // Refresh setiap 10 detik
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 10000);
        });
    </script>
</body>
</html>