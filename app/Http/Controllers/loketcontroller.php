<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AntrianController extends Controller
{
    /**
     * Menampilkan view untuk role loket.
     *
     * @return \Illuminate\View\View
     */
    public function showLoketView()
    {
        return view('loket.index');
    }
}
