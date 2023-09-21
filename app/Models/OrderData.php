<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_instansi',
        'email_instansi',
        'keperluan_iklan',
        'deskripsi_iklan',
        'mulai_iklan',
        'akhir_iklan',
        'lama_hari',
        'foto_iklan',
        'status_iklan',
        'order_iklan',
        'status_pembayaran',
        'dibayar_pada',
    ];

    public $timestamps = false;

    protected $primaryKey = 'order_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function packet(): BelongsTo
    {
        return $this->belongsTo(PacketData::class, 'packet_id', 'packet_id');
    }
}
