<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    // Daftar kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'nik',
        'no_rm',
        'name',
        'birth_date',
        'gender',
        'mother_name',
        'address',
        'region',
        'phone_number',
    ];
}