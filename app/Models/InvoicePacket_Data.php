<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class InvoicePacket_Data extends Model
{
    use HasFactory, HasCompositeKey;

    /**
     * fillable
     *
     * @var array
     */

    protected $primaryKey = ['Nama Paket', 'Invoice'];
}
