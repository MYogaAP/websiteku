<?php

namespace App\Http\Resources;

use App\Models\OrderData;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrdersListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = json_decode(json_encode(parent::toArray($request)));
        $PacketData = $data->order_detail->packet_data;
        try {
            $OrderDetail = OrderDetail::findOrFail($this->order_detail_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }
        return [
            'order_id' => $this->order_id,
            'nomor_invoice' => $this->nomor_invoice,
            'nomor_order' => $this->nomor_order,
            'nomor_seri' => $this->nomor_seri,
            'nama_instansi' => $OrderDetail->nama_instansi,
            'deskripsi_iklan' => $OrderDetail->deskripsi_iklan,
            'mulai_iklan' => $OrderDetail->mulai_iklan,
            'akhir_iklan'=> $OrderDetail->akhir_iklan,
            'foto_iklan' => $OrderDetail->foto_iklan,
            'status_pembayaran' => $OrderDetail->getStatusPembayaranDisplay(),
            'status_iklan' => $OrderDetail->getStatusIklanDisplay(),
            'detail_kemajuan' => $OrderDetail->detail_kemajuan,
            'invoice_id' => $OrderDetail->invoice_id,
            'tinggi' => $PacketData->tinggi,
            'kolom' => $PacketData->kolom,
            'harga_paket' => $PacketData->harga_paket,
        ];
    }
}
