@extends('layouts.admin')

@section('title', 'Dashboard Loket Pendaftaran')

@section('content')
<div class="row mb-3">
    <!-- Box Jumlah Antrian -->
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Jumlah Antrian</h5>
                <p class="card-text">{{ $jumlahAntrian }}</p>
            </div>
        </div>
    </div>
    
    <!-- Box Sisa Antrian -->
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Sisa Antrian</h5>
                <p class="card-text">{{ $sisaAntrian }}</p>
            </div>
        </div>
    </div>

    <!-- Box Antrian Selesai -->
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Antrian Selesai</h5>
                <p class="card-text">{{ $antrianSelesai }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Antrian -->
<div class="card">
    <div class="card-header">
        Tabel Data Antrian
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No. Antrian</th>
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataAntrian as $antrian)
                <tr>
                    <td>{{ $antrian->no_antrian }}</td>
                    <td>{{ $antrian->no_rm }}</td>
                    <td>{{ $antrian->nama_pasien }}</td>
                    <td>{{ $antrian->tanggal_kunjungan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataAntrian->links() }} <!-- Pagination -->
    </div>
</div>

<!-- Box Antrian Loket -->
<div class="mt-3">
    <div class="card">
        <div class="card-header">
            Antrian Loket
        </div>
        <div class="card-body">
            <h2>{{ $antrianLoket }}</h2>
            <button class="btn btn-success">Panggil</button>
        </div>
    </div>
</div>
@endsection
