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
        Schema::create('packet_data', function (Blueprint $table) {
            $table->id('packet_id');
            $table->string('nama_paket');
            $table->integer('tinggi');
            $table->integer('kolom');
            $table->enum('format_warna', ['fc', 'bw']);
            $table->integer('harga_paket');
            $table->string('contoh_foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packet_data');
    }
};
