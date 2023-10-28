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
            $table->string('nomor_order', 255)->nullable();
            $table->string('nama_instansi');
            $table->string('email_instansi');
            $table->string('nomor_instansi');
            $table->text('deskripsi_iklan');
            $table->date('mulai_iklan');
            $table->date('akhir_iklan');
            $table->integer('lama_hari');
            $table->string('foto_iklan');
            $table->enum('status_iklan', ['Menunggu Konfirmasi', 'Dalam Antrian', 'Sedang Diproses', 'Telah Diupload', 'Dibatalkan'])->default('Menunggu Konfirmasi');
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas', 'Dibatalkan'])->default('Belum Lunas');
            $table->string('nomor_invoice', 255)->nullable();
            $table->string('invoice_id', 255)->nullable();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('packet_id');
            $table->foreign('packet_id')->references('packet_id')->on('packet_data');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->timestamps();
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
