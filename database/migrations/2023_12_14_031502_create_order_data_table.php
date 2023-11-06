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
            $table->string('nomor_invoice', 255)->nullable();
            $table->string('nomor_seri', 255)->nullable();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('order_detail_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('agent_id')->references('user_id')->on('users');
            $table->foreign('order_detail_id')->references('order_detail_id')->on('order_details');
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
