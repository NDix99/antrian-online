<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrians'; // Nama tabel di database, jika tidak sesuai dengan konvensi Laravel
    
    protected $fillable = [
        'no_rm',
        'tanggal_kunjungan',
        'status',
    ];
}