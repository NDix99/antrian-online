<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        $request->validate([
            'nik' => 'required|string|size:16'
        ]);

        $patient = Patient::where('nik', $request->nik)->first();

        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => [
                    'nik' => $patient->nik,
                    'name' => $patient->name,
                    'no_rm' => $patient->no_rm
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data pasien tidak ditemukan'
        ]);
    }
}
