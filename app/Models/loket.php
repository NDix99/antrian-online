<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_loket',
        'nomor_loket',
        'status',
    ];

    /**
     * Get the user associated with the loket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the antrians for the loket.
     */
    public function antrians()
    {
        return $this->hasMany(Antrian::class);
    }
}
