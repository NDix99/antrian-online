<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    // Daftar kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'nik',
        'name',
        'birth_date',
        'gender',
        'mother_name',
        'address',
        'region',
        'phone_number',
    ];
}
