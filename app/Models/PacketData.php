<?php

namespace App\Models;

use App\Models\OrderData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PacketData extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'nama_paket',
        'tinggi',
        'kolom',
        'format_warna',
        'hidden',
        'harga_paket',
        'contoh_foto',
    ];

    protected $dates = ['deleted_at'];
    protected $table = 'packet_data';

    public function PacketOrder(): HasMany
    {
        return $this->hasMany(OrderData::class, 'packet_id', 'packet_id');
    }
}
