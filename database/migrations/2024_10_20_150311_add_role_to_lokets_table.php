<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    /**
     * Reverse the migrations.
     */
    public function up()
    {
        Schema::create('lokets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_loket');
            $table->string('role')->default('loket');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lokets');
    }
    
};
