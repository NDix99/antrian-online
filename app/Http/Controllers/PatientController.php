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
     * Memeriksa nomor rekam medis berdasarkan NIK.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkMedicalRecord(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
        ]);

        $patient = Patient::where('nik', $request->nik)->first();

        if ($patient) {
            return redirect()->route('patient.cekrm')->with('rm_number', $patient->id);
        } else {
            return redirect()->route('patient.cekrm')->with('error', 'NIK tidak ditemukan. Silakan daftar sebagai pasien baru.');
        }
    }
    /**
     * Menampilkan form pendaftaran pasien baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Menyimpan data pasien baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nik' => 'required|unique:patients,nik|max:16',
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'mother_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        // Simpan data pasien ke database
        Patient::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'region' => $request->region,
            'phone_number' => $request->phone_number,
        ]);

        // Redirect ke halaman lain setelah data disimpan
        return redirect()->route('patient.create')->with('success', 'Data pasien berhasil disimpan!');
    }

    /**
     * Menampilkan daftar pasien.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patient.index', compact('patients'));
    }

    /**
     * Menampilkan data pasien tertentu untuk diedit.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\View\View
     */
    public function edit(Patient $patient)
    {
        return view('patient.edit', compact('patient'));
    }

    /**
     * Memperbarui data pasien yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Patient $patient)
    {
        // Validasi data yang di-update
        $request->validate([
            'nik' => 'required|max:16|unique:patients,nik,' . $patient->id,
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'mother_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        // Update data pasien
        $patient->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'mother_name' => $request->mother_name,
            'address' => $request->address,
            'region' => $request->region,
            'phone_number' => $request->phone_number,
        ]);

        // Redirect setelah update
        return redirect()->route('patient.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    /**
     * Menghapus data pasien.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Patient $patient)
    {
        // Hapus pasien
        $patient->delete();

        // Redirect setelah penghapusan
        return redirect()->route('patient.index')->with('success', 'Data pasien berhasil dihapus!');
    }
}
