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
        Schema::create('invoice_data', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->string('invoice', 255);
            $table->dateTimeTz('tanggal_bayar', $precision = 0);
            $table->enum('status_pembayaran', ['menunggu pembayaran', 'lunas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_data');
    }
};
