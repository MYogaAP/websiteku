<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketData extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nama_paket',
        'tinggi',
        'kolom',
        'format_warna',
        'harga_paket',
    ];
}
