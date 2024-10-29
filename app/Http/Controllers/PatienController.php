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
}
