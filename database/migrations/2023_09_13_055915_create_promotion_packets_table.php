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
        Schema::create('promotion_packets', function (Blueprint $table) {
            $table->string('Nama Paket');
            $table->primary('Nama Paket');
            $table->integer('Tinggi');
            $table->integer('Kolom');
            $table->enum('Format Warna', ['Full Color', 'Black White']);
            $table->integer('Harga Paket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_packets');
    }
};
