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
        Schema::create('order_packets', function (Blueprint $table) {
            $table->unsignedBigInteger('packet_id');
            $table->unsignedBigInteger('order_id');

            $table->foreign('packet_id')->references('packet_id')->on('packet_data');
            $table->foreign('order_id')->references('order_id')->on('order_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_packets');
    }
};
