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

            // Ambil data pasien berdasarkan no_rm
            $patient = Patient::where('no_rm', $request->no_rm)->first();
            
            // Buat antrian baru dengan mengambil nama dari data pasien
            $antrian = Antrian::create([
                'no_antrian' => $noAntrian,
                'no_rm' => $request->no_rm,
                'nama' => $patient ? $patient->nama : 'Unknown',
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

    public function getData()
    {
        $data = Antrian::select(['no_antrian', 'no_rm', 'nama', 'tanggal_kunjungan'])
            ->latest('tanggal_kunjungan')
            ->when(request()->input('search.value'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('no_antrian', 'like', "%{$search}%")
                      ->orWhere('no_rm', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%");
                });
            });
        
        return DataTables::of($data)
            ->smart(true)
            ->rawColumns(['action'])
            ->make(true);
    }
}

