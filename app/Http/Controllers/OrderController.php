<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OrderData;
use App\Models\UserOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    function GetUserOrders($id) {
        
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
        $request->merge([
            'lama_hari' => $days,
            'user_id'=> Auth::user()->user_id,
        ]);
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
        ]);
    }
}
