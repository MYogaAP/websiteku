<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama_instansi',
        'email_instansi',
        'keperluan_iklan',
        'deskripsi_iklan',
        'mulai_iklan',
        'akhir_iklan',
        'lama_hari Iklan',
        'foto_iklan',
    ];
}
