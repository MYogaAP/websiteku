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
        return [
            'order_id' => $this->order_id,
            'nama_instansi' => $this->nama_instansi,
            'mulai_iklan' => $this->mulai_iklan,
            'akhir_iklan'=> $this->akhir_iklan,
            'status_pembayaran' => $this->status_pembayaran,
            'status_iklan' => $this->status_iklan,
        ];
    }
}
