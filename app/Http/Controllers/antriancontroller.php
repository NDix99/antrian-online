<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
class AntrianController extends Controller
{
    /**
     * Menampilkan view untuk role loket.
     *
     * @return \Illuminate\View\View
     */
 
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'no_rm' => 'required|string|max:255',
            'tanggal_kunjungan' => 'required|date',
        ]);

        // Simpan data ke tabel antrian
        Antrian::create([
            'no_rm' => $request->no_rm,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'status' => 'Menunggu', // Tambahkan field lainnya sesuai kebutuhan
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Nomor antrian berhasil diambil.');
    }
}

