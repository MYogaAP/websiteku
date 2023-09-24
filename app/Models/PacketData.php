<?php

namespace App\Models;

use App\Models\OrderData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'contoh_foto',
    ];

    public function PacketOrder(): HasMany
    {
        return $this->hasMany(OrderData::class, 'packet_id', 'packet_id');
    }
}
