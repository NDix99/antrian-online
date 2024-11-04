<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->string('nik');                                                  // Primary key
            $table->string('no_antrian', 300);                                      // Nomor antrian
            $table->string('no_rm', 10);                                            // Nomor rekam medis
            $table->date('tanggal_kunjungan');                                      // Tanggal kunjungan
            $table->enum('status', ['waiting', 'called', 'completed']);             // Status antrian
            $table->unsignedBigInteger('loket_id');                                 // Foreign key untuk loket
            $table->timestamps('created_at');                                       // waktu dibuat
            $table->timestamps('updated_at');                                       // waktu di perbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
