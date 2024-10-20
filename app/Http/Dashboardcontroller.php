<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian; // Misalkan Antrian adalah model untuk tabel antrian

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data dari database
        $jumlahAntrian = Antrian::count();
        $sisaAntrian = Antrian::where('status', 'menunggu')->count();
        $antrianSelesai = Antrian::where('status', 'selesai')->count();
        $dataAntrian = Antrian::paginate(10);
        $antrianLoket = Antrian::where('status', 'dipanggil')->first();

        // Mengirim data ke view
        return view('admin.dashboard', [
            'jumlahAntrian' => $jumlahAntrian,
            'sisaAntrian' => $sisaAntrian,
            'antrianSelesai' => $antrianSelesai,
            'dataAntrian' => $dataAntrian,
            'antrianLoket' => $antrianLoket ? $antrianLoket->no_antrian : 'Tidak Ada'
        ]);
    }
}
