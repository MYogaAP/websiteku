<?php

namespace App\Http\Controllers;

use App\Models\OrderData;
use App\Models\PacketData;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\OrdersListResource;
use App\Http\Resources\OrderDetailedResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    function GetUserOrdersList() {
        $orders = OrderData::where("user_id", Auth::user()->user_id)
        ->with(['OrderDetail', 'OrderDetail.PacketData'])
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
        ->simplePaginate(5);
        return OrdersListResource::collection($orders);
    }

    function GetOrderDetail($order_id) {
        $order = OrderData::with(['OrderDetail', 'OrderDetail.PacketData'])
        ->where("order_id", $order_id)
        ->get();
        return OrderDetailedResource::collection($order);
    }

    function AllDetailedOrders() {
        $orders = OrderData::with(['OrderDetail', 'OrderDetail.PacketData'])
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
        ->get();
        return OrderDetailedResource::collection($orders);
    }

    function AgentResponsibilityOrders() {
        $orders = OrderData::with(['OrderDetail', 'OrderDetail.PacketData'])
        ->where('agent_id', Auth::user()->user_id)
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
        ->get();
        return OrderDetailedResource::collection($orders);
    }

    function NeedConfirmation() {
        $orders = OrderData::with(['OrderDetail', 'OrderDetail.PacketData'])
        ->whereHas('OrderDetail', function ($query) {
            $query->where('status_iklan', 1);
        })
        ->orderByDesc(OrderDetail::select('status_pembayaran')
            ->whereColumn('order_detail_id', 'order_data.order_detail_id')
            ->latest()
        )
        ->orderByDesc(OrderDetail::select('status_iklan')
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
        ->get();
        return OrderDetailedResource::collection($orders);
    }

    function UpdateOrder($order_id, $update_type, $status) {
        try {
            $editOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }

        if($update_type == 1){
            $editOrder->OrderDetail->status_iklan = $editOrder->OrderDetail->getStatusIklanValue($status);
        } elseif ($update_type == 2){
            $editOrder->OrderDetail->status_pembayaran = $editOrder->OrderDetail->getStatusPembayaranValue($status);
        } 
        $editOrder->save();
        
        return response()->json([
            'message' => 'Order berhasil diperbaharui.',
        ]);
    }

    function OrderPayed($order_id) {
        try {
            $editOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }

        $editOrder->OrderDetail->status_iklan = $editOrder->OrderDetail->getStatusIklanValue("Sedang Diproses");
        $editOrder->OrderDetail->status_pembayaran = $editOrder->OrderDetail->getStatusPembayaranValue("Lunas");
        $editOrder->save();
        
        return response()->json([
            'message' => 'Order berhasil diperbaharui.',
        ]);
    }

    function ConfirmOrder(Request $request, $order_id, $update_type) {
        try {
            $confirmOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }
        $filePath = $confirmOrder->OrderDetail->foto_iklan;
        $msgTolak = "Telah dibatalkan oleh anggota tim Biro Iklan Radar Banjarmasin";
        $msgTerima = "Telah diterima oleh anggota tim Biro Iklan Radar Banjarmasin";
        $validate = $request ->validate([
            'invoice_id' => 'max:255',
            'nomor_order' => 'max:255',
            'nomor_invoice' => 'max:255',
            'nomor_seri' => 'max:255',
            'detail_kemajuan' => 'max:255'
        ]);

        if($update_type == 1) {
            if (Storage::exists('\image\\'.$filePath)){
                $confirmOrder->OrderDetail->status_iklan = $confirmOrder->OrderDetail->getStatusIklanValue("Menunggu Pembayaran");
                $confirmOrder->OrderDetail->status_pembayaran = $confirmOrder->OrderDetail->getStatusPembayaranValue("Belum Lunas");
                $confirmOrder->OrderDetail->invoice_id = $validate["invoice_id"];
                $confirmOrder->OrderDetail->detail_kemajuan = isset($validate["detail_kemajuan"]) ? $validate["detail_kemajuan"] : $msgTerima;
                $confirmOrder->OrderDetail->save();
                $confirmOrder->agent_id = Auth::user()->user_id;
                $confirmOrder->nomor_order = $validate["nomor_order"];
                $confirmOrder->nomor_invoice = $validate["nomor_invoice"];
                $confirmOrder->nomor_seri = $validate["nomor_seri"];
                $confirmOrder->save();

                return response()->json([
                    'message' => 'Order berhasil diperbaharui.',
                ]);
            }
        } elseif ($update_type == 2) {            
            if (Storage::exists('\image\\'.$filePath)){                
                $confirmOrder->OrderDetail->detail_kemajuan = isset($validate["detail_kemajuan"]) ? $validate["detail_kemajuan"] : $msgTolak;
                $confirmOrder->OrderDetail->status_iklan = $confirmOrder->OrderDetail->getStatusIklanValue('Dibatalkan');
                $confirmOrder->OrderDetail->status_pembayaran =  $confirmOrder->OrderDetail->getStatusPembayaranValue('Dibatalkan');
                $confirmOrder->OrderDetail->foto_iklan = 'none';
                $confirmOrder->agent_id = null;
                $confirmOrder->save();
                $confirmOrder->OrderDetail->save();
                Storage::delete('\image\\'.$filePath);

                return response()->json([
                    'message' => 'Order telah berhasil dibatalkan.',
                ]);
            }
        }
        
        return response()->json([
            'message' => 'Order gagal diedit.'
        ], 404);
    }

    function CheckImage(Request $request) {
        $packet = PacketData::where("packet_id", $request->packet_id)->get();
        $width = floor($packet[0]->kolom * 500);
        $height = floor(($packet[0]->tinggi/50) * 500);

        $rules = [
            'image'=>[
                'required',
                'image',
                'dimensions:width='.$width.',height='.$height,
            ],
        ];

        $messages = [
            'dimensions' => 'Ukuran yang diupload tidak sesuai. Ukuran yang disarankan adalah '.$width.'px lebar dan '.$height.'px tinggi.',
        ];

        $validate = $request->validate($rules, $messages);

        return response()->json([
            'message' => 'Ukuran gambar sudah tepat.',
            'berhasil' => true,
        ]);
    }

    function StoreOrder(Request $request) {
        $validate = $request ->validate([
            'nama_instansi' => 'required|max:255',
            'email_instansi' => 'required|email',
            'nomor_instansi' => 'required|numeric',
            'alamat_instansi' => 'required',
            'deskripsi_iklan' => 'required',
            'mulai_iklan' => 'required|date',
            'akhir_iklan' => 'required|date',
            "lama_hari" => 'required',
            'image'=>'required|image',
            'packet_id'=>'required',
        ]);

        $fileName = '';
        $extension  = '';
        $fullName = '';
        if($request->image){
            $fileName = Str::random(30);
            $extension =  $request->image->extension();
            $fullName = $fileName.'.'.$extension;

            Storage::putFileAs('image', $request->image, $fullName);
        }

        $request['foto_iklan'] = $fullName;
        $request['nomor_instansi'] = $request->nomor_instansi;
        $order_detail = OrderDetail::create($request->all());

        OrderData::create([
            "user_id" => Auth::user()->user_id,
            "order_detail_id" => $order_detail->order_detail_id,
        ]);

        return response()->json([
            'message' => 'Order telah berhasil kirimkan.',
        ]);
    }

    function CancelOrder($order_id) {
        try {
            $cancelOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }
        $filePath = $cancelOrder->OrderDetail->foto_iklan;

        if (Storage::exists('\image\\'.$filePath)){            
            $cancelOrder->OrderDetail->status_iklan = $cancelOrder->OrderDetail->getStatusIklanValue('Dibatalkan');
            $cancelOrder->OrderDetail->status_pembayaran =  $cancelOrder->OrderDetail->getStatusPembayaranValue('Dibatalkan');
            $cancelOrder->OrderDetail->foto_iklan = 'none';
            $cancelOrder->agent_id = null;
            $cancelOrder->save();
            $cancelOrder->OrderDetail->save();
            Storage::delete('\image\\'.$filePath);

            return response()->json([
                'message' => 'Order telah berhasil dibatalkan.',
            ]);
        }

        return response()->json([
            'message' => 'Order gagal dibatalkan.',
        ], 404);
    }
}
