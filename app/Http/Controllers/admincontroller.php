<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class AdminController extends Controller

{
  
    /**
     * Menampilkan halaman pengaturan admin.
     *
     * @return \Illuminate\View\View
     */
    public function showAdminSetting()
    {
        return view('admin.setting');
    }
}