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
            
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Sisa Antrian</h2>
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2" id="sisaAntrian">0</p>
            </div>
            
            <div class="bg-white p-4 rounded shadow border border-green-500">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Antrian Selesai</h2>
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <p class="text-4xl font-bold mt-2" id="antrianSelesai">0</p>
            </div>
            
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
    <div class="mt-8">
        <div class="flex gap-4">
            <!-- Tombol Cek Data Antrian -->
            <div class="w-1/8">
                <a href="#" 
                   class="flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-search text-3xl mb-2"></i>
                    <span class="text-lg font-semibold">Cek Data Antrian</span>
                </a>
            </div>

            <!-- Tabel Data Antrian -->
            <div class="w-3/4 bg-white p-4 rounded shadow">
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

            <!-- Loket Control Panel -->
            <div class="w-1/4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Header Loket -->
                    <div class="bg-green-600 text-white p-4 text-center">
                        <h2 class="text-xl font-bold">Loket 1</h2>
                    </div>
                    
                    <!-- Nomor Antrian Display -->
                    <div class="p-8 text-center">
                        <div class="text-8xl font-bold mb-6">1</div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="flex justify-center items-center gap-4 p-4">
                        <button class="p-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <button class="px-6 py-3 bg-yellow-400 text-gray-800 rounded-lg hover:bg-yellow-300 flex items-center gap-2">
                            <span>Panggil</span>
                            <i class="fas fa-microphone"></i>
                        </button>
                        <button class="p-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Panggil Ulang Section -->
                    <div class="p-4 border-t">
                        <h3 class="font-semibold mb-3">Panggil Ulang</h3>
                        <div class="flex gap-2">
                            <input type="text" 
                                   placeholder="Nomor Antrian" 
                                   class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <button class="p-2 bg-yellow-400 text-gray-800 rounded-lg hover:bg-yellow-300">
                                <i class="fas fa-microphone"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            $('#queueTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('antrian.data') }}",
                columns: [
                    { data: 'no_antrian', name: 'no_antrian' },
                    { data: 'no_rm', name: 'no_rm' },
                    { data: 'nama', name: 'nama' },
                    { data: 'tanggal_kunjungan', name: 'tanggal_kunjungan' }
                ]
            });

        });
    </script>
</body>
</html>