<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $orders = OrderData::where("user_id", Auth::user()->user_id)->simplePaginate(10);
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

    function UpdateOrder($order_id, $status_iklan) {
        $confirmOrder = OrderData::findOrFail($order_id);

        $confirmOrder->status_iklan = $status_iklan;
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
            'nama_instansi' => 'required|max:255',
            'email_instansi' => 'required|email',
            'deskripsi_iklan' => 'required',
            'mulai_iklan' => 'required|date',
            'akhir_iklan'  => 'required|date',
            'image'=>'required|image',
            'packet_id'=>'required',
            'order_invoice'=>'required'
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

        $start = Carbon::parse($request->mulai_iklan); 
        $end = Carbon::parse($request->akhir_iklan);
        $days = 1 + ($end->diffInDays($start));

        $request['foto_iklan'] = $fullName;
        $request['user_id'] = Auth::user()->user_id;
        $request['lama_hari'] = $days;
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
