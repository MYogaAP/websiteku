<?php

namespace App\Models;

use App\Models\User;
use App\Models\PacketData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_instansi',
        'email_instansi',
        'deskripsi_iklan',
        'mulai_iklan',
        'akhir_iklan',
        'lama_hari',
        'foto_iklan',
        'status_iklan',
        'order_invoice',
        'status_pembayaran',
        'dibayar_pada',
        'user_id',
        'packet_id',
    ];

    protected $hidden = [
        'user_id', 'packet_id'
    ];

    protected $primaryKey = 'order_id';

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function PacketData(): BelongsTo
    {
        return $this->belongsTo(PacketData::class, 'packet_id', 'packet_id');
    }
}
