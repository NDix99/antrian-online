<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    /**
     * Menampilkan halaman cek nomor rekam medis.
     *
     * @return View
     */
    public function showCheckRMForm(): View
    {
        return view('patient.cekrm');
    }

    /**
     * Melakukan pengecekan nomor rekam medis berdasarkan NIK.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkRM(Request $request): \Illuminate\Http\JsonResponse
    {
        $nik = $request->input('nik');
        
        $patient = Patient::where('nik', $nik)->first();
        
        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => [
                    'nik' => $patient->nik,
                    'nama' => $patient->nama,
                    'no_rm' => $patient->no_rm
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Data pasien tidak ditemukan. Silakan periksa kembali NIK anda atau lakukan pendaftaran di tempat.'
        ]);
    }

    /**
     * Menampilkan data antrian berdasarkan NIK.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAntrian(Request $request)
    {
        try {
            $today = now()->toDateString();
            
            $query = Antrian::select(['no_antrian', 'no_rm', 'nama', 'tanggal_kunjungan'])
                ->whereDate('tanggal_kunjungan', $today);
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
                
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
