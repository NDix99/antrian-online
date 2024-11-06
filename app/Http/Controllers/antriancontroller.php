<?php

namespace App\Models;
namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TicketImageService;
use Yajra\DataTables\Facades\DataTables;

class AntrianController extends Controller
{
    protected $ticketImageService;

    public function __construct(TicketImageService $ticketImageService)
    {
        $this->ticketImageService = $ticketImageService;
    }

    public function ambil(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'no_rm' => 'required',
                'tanggal_kunjungan' => 'required|date'
            ]);

            // Cek apakah no_rm terdaftar di database patient
            $patient = Patient::where('no_rm', $request->no_rm)->first();
            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor RM tidak terdaftar dalam database silahkan melakukan registrasi terlebih dahulu di Rumah Sakit'
                ]);
            }

            // Cek apakah pasien sudah mengambil antrian di tanggal yang sama
            $existingAntrian = Antrian::where('no_rm', $request->no_rm)
                                    ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                    ->first();

            if ($existingAntrian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengambil nomor antrian untuk tanggal ini'
                ]);
            }

            // Generate nomor antrian
            $lastAntrian = Antrian::where('tanggal_kunjungan', $request->tanggal_kunjungan)
                                 ->orderBy('no_antrian', 'desc')
                                 ->first();

            // Tentukan nomor urut berikutnya
            if ($lastAntrian) {
                $nomorUrut = (int)$lastAntrian->no_antrian + 1;
            } else {
                $nomorUrut = 1;
            }

            // Format: 001, 002, dst
            $noAntrian = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

            // Buat antrian baru dengan nama dari data pasien
            $antrian = Antrian::create([
                'no_antrian' => $noAntrian,
                'no_rm' => $request->no_rm,
                'nama' => $patient->nama,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'status' => 'menunggu'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil nomor antrian',
                'data' => $antrian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function getTotal()
    {
        try {
            $total = Antrian::whereDate('tanggal_kunjungan', Carbon::today())->count();
            return response()->json(['total' => $total]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }

    public function getData(Request $request)
    {
        $query = Antrian::select([
            'no_antrian',
            'no_rm',
            'nama',
            'tanggal_kunjungan'
        ])->whereDate('tanggal_kunjungan', Carbon::today());

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }
}

