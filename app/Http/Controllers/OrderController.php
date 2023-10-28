<?php

namespace App\Http\Controllers;

use App\Models\OrderData;
use App\Models\UserOrder;
use App\Models\PacketData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\OrdersListResource;
use App\Http\Resources\OrderDetailResource;
use Illuminate\Validation\Rules\Dimensions;

class OrderController extends Controller
{
    function GetUserOrdersList() {
        $orders = OrderData::with('PacketData')
        ->where("user_id", Auth::user()->user_id)
        ->orderBy("status_pembayaran", "asc")
        ->orderBy("created_at", "desc")
        ->orderBy("mulai_iklan", "desc")
        ->orderBy("status_iklan", "desc")
        ->simplePaginate(5);
        return OrdersListResource::collection($orders);
    }

    function GetOrderDetail($order_id) {
        $order = OrderData::with('PacketData')
        ->where("order_id", $order_id)
        ->get();
        return OrderDetailResource::collection($order);
    }

    function AllOrders() {
        $orders = OrderData::all();
        return OrdersListResource::collection($orders);
    }

    function NeedConfirmation() {
        $orders = OrderData::where('status_pembayaran', 'Berhasil')->simplePaginate(5);
        return OrdersListResource::collection($orders);
    }

    function UpdateOrder($order_id, $update_type, $status) {
        $confirmOrder = OrderData::findOrFail($order_id);

        if($update_type == 1){
            $confirmOrder->status_iklan = $status;
        } elseif ($update_type == 2){
            $confirmOrder->status_pembayaran = $status;
        }
        $confirmOrder->save();
        
        return response()->json([
            'message' => 'Order has been succesfully updated.',
        ]);
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
            // 'nomor_order'=>'required',
            'nama_instansi' => 'required|max:255',
            'email_instansi' => 'required|email',
            'nomor_instansi' => 'required|numeric',
            'deskripsi_iklan' => 'required',
            'mulai_iklan' => 'required|date',
            'akhir_iklan' => 'required|date',
            "lama_hari" => 'required',
            'image'=>'required|image',
            'packet_id'=>'required',
            // 'nomor_invoice'=>'required',
            'invoice_id'=>'required',
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
        $request['user_id'] = Auth::user()->user_id;
        $request['nomor_instansi'] = $request->nomor_instansi;
        $order_data = OrderData::create($request->all());

        return response()->json([
            'message' => 'Order has been succesfully made.',
        ]);
    }

    function CancelOrder($order_id) {
        $cancelOrder = OrderData::findOrFail($order_id);

        $filePath = $cancelOrder->foto_iklan;
        if (Storage::exists('\image\\'.$filePath)){
            
            Storage::delete('\image\\'.$filePath);
            
            $cancelOrder->status_iklan = 'Dibatalkan';
            $cancelOrder->status_pembayaran =  'Dibatalkan';
            $cancelOrder->foto_iklan = 'none';
            $cancelOrder->save();

            return response()->json([
                'message' => 'Order has been succesfully canceled.',
            ]);
        }

        return response()->json([
            'message' => 'Canceling order failed.',
        ], 404);
    }
}
