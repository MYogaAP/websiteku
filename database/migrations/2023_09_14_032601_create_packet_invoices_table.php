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
        Schema::create('packet_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('packet_id');
            $table->unsignedBigInteger('invoice_id');

            $table->foreign('packet_id')->references('packet_id')->on('packet_data');
            $table->foreign('invoice_id')->references('invoice_id')->on('invoice_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packet_invoices');
    }
};