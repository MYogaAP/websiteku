<?php

namespace App\Exports;

use App\Models\OrderData;
use App\Models\OrderDetail;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataTableExport implements FromCollection
{
    use Exportable;

    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderData::with(['OrderDetail', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
        ->whereDoesntHave('OrderDetail', function ($query) {
            $query->where('status_iklan', 5);
        })
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
        ->whereMonth('created_at', $this->month)
        ->get();
    }
}
