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
        Schema::create('order__data', function (Blueprint $table) {
            $table->integer('Order_ID');
            $table->primary('Order_ID');
            $table->string('Nama Instansi');
            $table->string('Email Instansi')->unique();
            $table->enum('Keperluan Iklan', ['Instansi', 'Pribadi', 'Akademik', 'Penjualan', 'Politik']);
            $table->text('Deskripsi Iklan', 200);
            $table->date('Mulai Iklan');
            $table->date('Akhir Iklan');
            $table->integer('Lama Hari Iklan');
            $table->string('Foto Iklan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__data');
    }
};
