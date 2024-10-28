<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Menampilkan halaman cek nomor rekam medis.
     *
     * @return \Illuminate\View\View
     */
    public function showCheckRMForm()
    {
        return view('patient.cekrm');
    }

    /**
     * Memproses pengecekan nomor rekam medis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkRM(Request $request)
    {
        $request->validate([
            'nomor_rm' => 'required|string|max:255',
        ]);

        $patient = Patient::where('nomor_rm', $request->nomor_rm)->first();

        if ($patient) {
            return view('patient.result', ['patient' => $patient]);
        } else {
            return back()->with('error', 'Nomor Rekam Medis tidak ditemukan.');
        }
    }
}
