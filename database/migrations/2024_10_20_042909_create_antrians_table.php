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
            $table->bigIncrements('no_antrian');                                         // Auto-increment primary key
        //  $table->string('nik')->nullable()->default(null);
            $table->string('no_rm', 10);                                                
            $table->date('tanggal_kunjungan')->default(now());                          
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
       //   $table->unsignedBigInteger('loket_id');                                     
            $table->timestamps();
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
