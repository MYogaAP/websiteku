<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'email_instansi' => $this->emil_instansi,
            'deskripsi_iklan' => $this->deskripsi_iklan,
            'mulai_iklan' => $this->mulai_iklan,
            'akhir_iklan'=> $this->akhir_iklan,
            'lama_hari' => $this->lama_hari,
            'foto_iklan' => $this->foto_iklan,
            'status_iklan' => $this->status_iklan,
            'order_invoice' => $this->order_invoice,
            'status_pembayaran' => $this->status_pembayaran,
            'dibayar_pada' => $this->dibayar_pada,
            'nama_paket' => $packetData->nama_paket,
            'harga_paket' => $packetData->harga_paket,
        ];
    }
}
