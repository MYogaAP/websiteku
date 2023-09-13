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
        Schema::create('invoice_packet__data', function (Blueprint $table) {
            $table->integer('Invoice');
            $table->string('Nama Paket');
            $table->primary(['Invoice', 'Nama Paket']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_packet__data');
    }
};
