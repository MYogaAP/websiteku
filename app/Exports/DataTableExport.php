<?php

namespace App\Exports;

use App\Models\OrderData;
use App\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Http\Resources\OrderExportResource;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataTableExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = OrderData::with(['OrderDetail', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
        // ->whereHas('OrderDetail', function ($query) {
        //     $query->where('status_pembayaran', 3);
        // })
        ->orderBy(OrderDetail::select('status_pembayaran')
            ->whereColumn('order_detail_id', 'order_data.order_detail_id')
            ->latest()
        )
        ->orderBy(OrderDetail::select('status_iklan')
            ->whereColumn('order_detail_id', 'order_data.order_detail_id')
            ->latest()
        )
        ->orderBy(OrderDetail::select('mulai_iklan')
            ->whereColumn('order_detail_id', 'order_data.order_detail_id')
            ->latest()
        )
        ->orderBy(OrderDetail::select('created_at')
            ->whereColumn('order_detail_id', 'order_data.order_detail_id')
            ->latest()
        )
        ->whereYear('created_at', $this->year)
        ->whereMonth('created_at', $this->month)
        ->get()
        ->map(function ($item) {
            unset($item['order_id']);
            return $item;
        });
        $orders = OrderExportResource::collection($data);

        return $orders;
    }

    public function headings(): array
    {
        return [
            'Nomor Invoice',
            'Nomor Order',
            'Nomor Seri',
            'Nama Instansi',
            'Email Instansi',
            'Nomor Instansi',
            'Deskripsi Iklan',
            'Alamat Instansi',
            'Mulai Tayang Iklan',
            'Akhir Tayang Iklan',
            'Lama Hari Tayang',
            'Nama File Foto Iklan',
            'Invoice Xendit',
            'Status Pembayaran',
            'Status Iklan',
            'Detail Kemajuan',
            'Nama Paket',
            'Format Warna',
            'Tinggi',
            'Kolom',
            'Harga Paket',
            'Total Harga',
            'Waktu Pembayaran',
            'Pemesan',
            'Email Pemesan',
            'Anggota Yang Bertanggung Jawab',
            'Email Anggota'
        ];
    }
}
