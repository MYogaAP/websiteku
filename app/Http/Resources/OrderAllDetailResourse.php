<?php

namespace App\Http\Resources;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderAllDetailResourse extends JsonResource
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
        $UserData = $data->user;
        $AgentData = $data->agent;
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
            'email_instansi' => $OrderDetail->email_instansi,
            'nomor_instansi' => $OrderDetail->nomor_instansi,
            'deskripsi_iklan' => $OrderDetail->deskripsi_iklan,
            'alamat_instansi' => $OrderDetail->alamat_instansi,
            'mulai_iklan' => $OrderDetail->mulai_iklan,
            'akhir_iklan'=> $OrderDetail->akhir_iklan,
            'lama_hari' => $OrderDetail->lama_hari,
            'foto_iklan' => $OrderDetail->foto_iklan,
            'invoice_id' => $OrderDetail->invoice_id,
            'status_pembayaran' => $OrderDetail->getStatusPembayaranDisplay(),
            'status_iklan' => $OrderDetail->getStatusIklanDisplay(),
            'detail_kemajuan' => $OrderDetail->detail_kemajuan,
            'tanggal_pembayaran' => isset($OrderDetail->tanggal_pembayaran)? $OrderDetail->tanggal_pembayaran : "-",
            'nama_paket' => $PacketData->nama_paket,
            'format_warna' => $PacketData->format_warna,
            'tinggi' => $PacketData->tinggi,
            'kolom' => $PacketData->kolom,
            'harga_paket' => $PacketData->harga_paket,
            'nama_pemesan' => isset($UserData->name)? $UserData->name:"-",
            'email_pemesan' => isset($UserData->email)? $UserData->email:"-",
            'nama_agent' => isset($AgentData->name)? $AgentData->name:"-",
            'email_agent' => isset($AgentData->email)? $AgentData->email:"-",
        ];
    }
}
