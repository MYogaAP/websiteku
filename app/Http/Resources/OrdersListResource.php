<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $packetData = json_decode(json_encode(parent::toArray($request)));
        $packetData = $packetData->packet_data;
        return [
            'order_id' => $this->order_id,
            'nama_instansi' => $this->nama_instansi,
            'deskripsi_iklan' => $this->deskripsi_iklan,
            'mulai_iklan' => $this->mulai_iklan,
            'akhir_iklan'=> $this->akhir_iklan,
            'foto_iklan' => $this->foto_iklan,
            'status_pembayaran' => $this->status_pembayaran,
            'status_iklan' => $this->status_iklan,
            'invoice_id' => $this->invoice_id,
            'tinggi' => $packetData->tinggi,
            'kolom' => $packetData->kolom,
            'harga_paket' => $packetData->harga_paket,
        ];
    }
}
