<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'email_instansi',
        'deskripsi_iklan',
        'nomor_instansi',
        'mulai_iklan',
        'akhir_iklan',
        'lama_hari',
        'foto_iklan',
        'status_iklan',
        'nomor_invoice',
        'status_pembayaran',
        'packet_id',
        'invoice_id',
        'detail_penolakan',
        'alamat_instansi'
    ];

    protected $enum = [
        'status_iklan' => [
            1 => 'Menunggu Konfirmasi', 
            2 => 'Menunggu Pembayaran', 
            3 => 'Sedang Diproses', 
            4 => 'Telah Tayang', 
            5 => 'Dibatalkan'
        ],
        'status_pembayaran' => [
            1 => 'Menunggu Konfirmasi', 
            2 => 'Belum Lunas', 
            3 => 'Lunas',
            4 => 'Dibatalkan'
        ],
    ];

    protected $primaryKey = 'order_detail_id';

    public function OrderData(): HasOne
    {
        return $this->hasOne(OrderData::class, 'order_detail_id', 'order_detail_id');
    }
    
    public function PacketData(): BelongsTo
    {
        return $this->belongsTo(PacketData::class, 'packet_id', 'packet_id');
    }

    public function getStatusPembayaranDisplay()
    {
        $statusPembayaranValue = $this->status_pembayaran;
        return $this->enum['status_pembayaran'][$statusPembayaranValue];
    }

    public function getStatusIklanDisplay()
    {
        $statusIklanValue = $this->status_iklan;
        return $this->enum['status_iklan'][$statusIklanValue];
    }

    public function getStatusPembayaranValue($statusPembayaranString)
    {
        return array_search($statusPembayaranString, $this->enum['status_pembayaran']);
    }

    public function getStatusIklanValue($statusIklanString)
    {
        return array_search($statusIklanString, $this->enum['status_iklan']);
    }
}
