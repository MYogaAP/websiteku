<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionPacket extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'Nama Paket',
        'Tinggi',
        'Kolom',
        'Format Warna',
        'Harga Paket',
    ];

}
