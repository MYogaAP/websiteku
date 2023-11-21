<?php

namespace App\Http\Resources;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Order Data
        $data = json_decode(json_encode(parent::toArray($request)));
        $PacketData = $data->order_detail->packet_data;
        try {
            $OrderDetail = OrderDetail::findOrFail($this->order_detail_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }

        // Xendit Data
        if(isset($OrderDetail->invoice_id)){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.xendit.co/v2/invoices/'.$OrderDetail->invoice_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.config('xendit.key')
            ),
            ));
            $invoice_data = curl_exec($curl);
            $invoice_data = json_decode($invoice_data);
            curl_close($curl);
        }

        return [
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
            'nama_paket' => $PacketData->nama_paket,
            'format_warna' => $PacketData->format_warna,
            'tinggi' => $PacketData->tinggi,
            'kolom' => $PacketData->kolom,
            'harga_paket' => $PacketData->harga_paket,
            'total_harga' => $PacketData->harga_paket * $OrderDetail->lama_hari,
            'tanggal_pembayaran' => isset($invoice_data->paid_at)? $invoice_data->paid_at : "-",
            'total_terbayar' => isset($invoice_data->amount)? $invoice_data->amount : "-",
        ];
    }
}
