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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();                                    // ID unik (Primary Key)
            $table->string('nik')->unique();                 // Nomor Induk Kependudukan (unik)
            $table->string('name');                          // Nama Lengkap
            $table->date('birth_date');                      // Tanggal Lahir
            $table->enum('gender', ['Laki-laki', 'Perempuan']); // Jenis Kelamin
            $table->string('mother_name');                   // Nama Ibu Kandung
            $table->string('address');                       // Alamat
            $table->string('region')->nullable();            // Wilayah (opsional)
            $table->string('phone_number');                  // Nomor Handphone
            $table->timestamps();                            // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};

