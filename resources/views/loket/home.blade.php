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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
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
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i> Tabel Data Antrian
                </h5>
            </div>
            <div class="card-body">
                <table id="queueTable" class="table table-striped table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Antrian</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Kunjungan</th>
                        </tr>
                    </thead>
                </table>
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
                    { 
                        data: 'no_antrian',
                        name: 'no_antrian',
                        className: 'text-center'
                    },
                    { 
                        data: 'no_rm',
                        name: 'no_rm'
                    },
                    { 
                        data: 'nama',
                        name: 'nama'
                    },
                    { 
                        data: 'tanggal_kunjungan',
                        name: 'tanggal_kunjungan',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY');
                        }
                    }
                ],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                pageLength: 10,
                order: [[0, 'asc']],
                responsive: true
            });
        });
    </script>

    <style>
        /* Beberapa penyesuaian tambahan */
        .dataTables_wrapper .dataTables_length select {
            width: auto;
            display: inline-block;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0.5em;
            display: inline-block;
            width: auto;
        }
        
        .dataTables_wrapper .dataTables_processing {
            background: rgba(255,255,255,0.9);
            padding: 1rem;
            border-radius: 0.5rem;
        }
    </style>
</body>
</html>