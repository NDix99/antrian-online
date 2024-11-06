<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $table = 'antrians';
    protected $primaryKey = 'no_antrian';
    protected $fillable = [
        'no_rm',
        'no_antrian',
        'nama',
        'status',
        'tanggal_kunjungan',
        'created_at',
        'updated_at'
    ];
}