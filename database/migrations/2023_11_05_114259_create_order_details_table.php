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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->string('nama_instansi');
            $table->string('email_instansi');
            $table->string('nomor_instansi');
            $table->text('alamat_instansi');
            $table->text('deskripsi_iklan');
            $table->date('mulai_iklan');
            $table->date('akhir_iklan');
            $table->integer('lama_hari');
            $table->string('foto_iklan');
            $table->enum('status_iklan', [1, 2, 3, 4, 5])->default(1);
            $table->enum('status_pembayaran', [1, 2, 3, 4])->default(1);
            $table->string('invoice_id', 255)->nullable();
            $table->string('detail_kemajuan', 255)->nullable();

            $table->unsignedBigInteger('packet_id');
            $table->foreign('packet_id')->references('packet_id')->on('packet_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
