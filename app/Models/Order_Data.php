<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Data extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'Order_ID',
        'Nama Instansi',
        'Email Instansi',
        'Keperluan Iklan',
        'Deskripsi Iklan',
        'Mulai Iklan',
        'Akhir Iklan',
        'Lama Hari Iklan',
        'Foto Iklan',
    ];
}
