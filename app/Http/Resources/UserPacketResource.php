<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPacketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'packet_id' => $this->packet_id,
            'nama_paket'=> $this->nama_paket,
            'tinggi' => $this -> tinggi,
            'kolom' => $this->kolom,
            'format_warna' => $this->format_warna,
            'harga_paket'  => $this->harga_paket,
            'contoh_foto' =>  $this->contoh_foto,
        ];
    }
}
