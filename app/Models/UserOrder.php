<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
    ];

    public $timestamps = false;

    // public function TheUser(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'user_id');
    // }

    // public function TheOrder(): HasOne
    // {
    //     return $this->hasOne(OrderData::class, 'order_id', 'order_id');
    // }
}
