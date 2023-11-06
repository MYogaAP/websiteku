<?php

namespace App\Models;

use App\Models\User;
use App\Models\PacketData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nomor_order',
        'nomor_invoice',
        'nomor_seri',
        'user_id',
        'agent_id',
        'order_detail_id'
    ];

    protected $hidden = [
        'user_id', 'agent_id', 'order_detail_id'
    ];

    protected $primaryKey = 'order_id';

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function Agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id', 'user_id');
    }

    public function OrderDetail(): HasOne
    {
        return $this->hasOne(OrderDetail::class, 'order_detail_id', 'order_detail_id');
    }
}
