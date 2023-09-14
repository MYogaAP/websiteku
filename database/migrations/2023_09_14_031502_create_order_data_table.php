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
        Schema::create('order_data', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('nama_instansi');
            $table->string('email_instansi');
            $table->enum('keperluan_iklan', ['instansi', 'pribadi', 'akademik', 'penjualan', 'politik']);
            $table->text('deskripsi_iklan', 255);
            $table->date('mulai_iklan');
            $table->date('akhir_iklan');
            $table->integer('lama_hari');
            $table->string('foto_iklan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_data');
    }
};
