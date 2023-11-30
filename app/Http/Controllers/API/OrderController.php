<?php

namespace App\Http\Controllers\API;

use App\Models\OrderData;
use App\Models\PacketData;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderAllDetailResourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\OrdersListResource;
use App\Http\Resources\OrderDetailedResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    function GetUserOrdersList() {
        $orders = OrderData::where("user_id", Auth::user()->user_id)
        ->with(['OrderDetail', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
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
        ->paginate(5);
        return OrdersListResource::collection($orders);
    }

    function GetOrderDetail($order_id) {
        $order = OrderData::with(['OrderDetail', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
        ->where("order_id", $order_id)
        ->get();
        return OrderDetailedResource::collection($order);
    }

    function AllDetailedOrders() {
        $orders = OrderData::with(['OrderDetail', 'User', 'Agent', 'OrderDetail.PacketData' => function ($query) {
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
        ->get();
        return OrderAllDetailResourse::collection($orders);
    }

    function AgentResponsibilityOrders() {
        $orders = OrderData::with(['OrderDetail', 'User', 'Agent', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
        ->where('agent_id', Auth::user()->user_id)
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
        ->get();
        return OrderAllDetailResourse::collection($orders);
    }

    function NeedConfirmation() {
        $orders = OrderData::with(['OrderDetail', 'User', 'Agent', 'OrderDetail.PacketData' => function ($query) {
            $query->withTrashed();
        }])
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
        return OrderAllDetailResourse::collection($orders);
    }

    function UpdateOrder(Request $request, $order_id, $update_type) {
        try {
            $editOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }

        $request->validate([
            'status' => 'required',
        ]);

        if($update_type == 1){
            $editOrder->OrderDetail->status_iklan = $editOrder->OrderDetail->getStatusIklanValue($request->status);
        } elseif ($update_type == 2){
            $editOrder->OrderDetail->status_pembayaran = $editOrder->OrderDetail->getStatusPembayaranValue($request->status);
        } 
        $editOrder->OrderDetail->detail_kemajuan = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "";
        $editOrder->OrderDetail->save();
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

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.xendit.co/v2/invoices/' . $editOrder->OrderDetail->invoice_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Authorization: Basic ' . config('xendit.test')],
        ]);
        $invoice_data = curl_exec($curl);
        $invoice_data = json_decode($invoice_data);
        curl_close($curl);

        $editOrder->OrderDetail->status_iklan = $editOrder->OrderDetail->getStatusIklanValue("Sedang Diproses");
        $editOrder->OrderDetail->status_pembayaran = $editOrder->OrderDetail->getStatusPembayaranValue("Lunas");
        $editOrder->OrderDetail->tanggal_pembayaran = now()->parse($invoice_data->paid_at)->addHours(8);
        $editOrder->OrderDetail->save();
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

        if($update_type == 1) {
            if (Storage::exists('\image\\'.$filePath)){
                $confirmOrder->OrderDetail->status_iklan = $confirmOrder->OrderDetail->getStatusIklanValue("Menunggu Pembayaran");
                $confirmOrder->OrderDetail->status_pembayaran = $confirmOrder->OrderDetail->getStatusPembayaranValue("Belum Lunas");
                $confirmOrder->OrderDetail->invoice_id = $request->invoice_id;
                $confirmOrder->OrderDetail->detail_kemajuan = isset($request->detail_kemajuan) ? $request->detail_kemajuan : $msgTerima;
                $confirmOrder->agent_id = Auth::user()->user_id;
                $confirmOrder->nomor_order = $request->nomor_order;
                $confirmOrder->nomor_invoice = $request->nomor_invoice;
                $confirmOrder->nomor_seri = $request->nomor_seri;
                $confirmOrder->OrderDetail->save();
                $confirmOrder->save();

                return response()->json([
                    'message' => 'Order berhasil diperbaharui.',
                ]);
            }
        } elseif ($update_type == 2) {            
            if (Storage::exists('\image\\'.$filePath)){                
                $confirmOrder->OrderDetail->detail_kemajuan = isset($request->detail_kemajuan) ? $request->detail_kemajuan : $msgTolak;
                $confirmOrder->OrderDetail->status_iklan = $confirmOrder->OrderDetail->getStatusIklanValue('Dibatalkan');
                $confirmOrder->OrderDetail->status_pembayaran =  $confirmOrder->OrderDetail->getStatusPembayaranValue('Dibatalkan');
                $confirmOrder->OrderDetail->foto_iklan = 'none';
                $confirmOrder->OrderDetail->save();
                $confirmOrder->save();
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
        $height = floor($packet[0]->tinggi/50 * 500);
        $width_data = [
            1 => 470,
            2 => 975,
            3 => 1480,
            4 => 1985,
            5 => 2495,
            6 => 3000
        ];
        $width = $width_data[$packet[0]->kolom];

        $rules = [
            'image'=>[
                'required',
                'image',
                'dimensions:width='.$width.',height='.$height,
            ],
        ];

        $messages = [
            'required' => 'Kolom gambar wajib diisi.',
            'image' => 'Berkas yang diunggah harus berupa gambar.',
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
        ], [
            'nama_instansi.required' => 'Kolom nama instansi wajib diisi.',
            'nama_instansi.max' => 'Kolom nama instansi tidak boleh lebih dari :max karakter.',
            'email_instansi.required' => 'Kolom email instansi wajib diisi.',
            'email_instansi.email' => 'Format email instansi tidak valid.',
            'nomor_instansi.required' => 'Kolom nomor instansi wajib diisi.',
            'nomor_instansi.numeric' => 'Kolom nomor instansi harus berupa angka.',
            'alamat_instansi.required' => 'Kolom alamat instansi wajib diisi.',
            'deskripsi_iklan.required' => 'Kolom deskripsi iklan wajib diisi.',
            'mulai_iklan.required' => 'Kolom mulai iklan wajib diisi.',
            'mulai_iklan.date' => 'Format tanggal mulai iklan tidak valid.',
            'akhir_iklan.required' => 'Kolom akhir iklan wajib diisi.',
            'akhir_iklan.date' => 'Format tanggal akhir iklan tidak valid.',
            'lama_hari.required' => 'Kolom lama hari wajib diisi.',
            'image.required' => 'Kolom gambar wajib diisi.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'packet_id.required' => 'Kolom packet ID wajib diisi.',
        ]);

        $fileName = '';
        $extension  = '';
        $fullName = '';
        if($request->image){
            $fileName = now()->format('d-M-Y')."_".Str::random(30);
            $extension =  $request->image->extension();
            $fullName = $fileName.'.'.$extension;

            Storage::putFileAs('image', $request->image, $fullName);
        }

        $request['foto_iklan'] = $fullName;
        $request['nomor_instansi'] = $request->nomor_instansi;
        $request['detail_kemajuan'] = "Telah dikirimkan ke tim biro iklan.";
        $order_detail = OrderDetail::create($request->all());

        OrderData::create([
            "user_id" => Auth::user()->user_id,
            "order_detail_id" => $order_detail->order_detail_id,
        ]);

        return response()->json([
            'message' => 'Order telah berhasil kirimkan.',
        ]);
    }

    function CancelOrder(Request $request, $order_id) {
        try {
            $cancelOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }
        $filePath = $cancelOrder->OrderDetail->foto_iklan;
        $msg = "Dibatalkan oleh sistem.";

        if (Storage::exists('\image\\'.$filePath)){            
            $cancelOrder->OrderDetail->detail_kemajuan = isset($request->detail_kemajuan) ? $request->detail_kemajuan : $msg;
            $cancelOrder->OrderDetail->status_iklan = $cancelOrder->OrderDetail->getStatusIklanValue('Dibatalkan');
            $cancelOrder->OrderDetail->status_pembayaran =  $cancelOrder->OrderDetail->getStatusPembayaranValue('Dibatalkan');
            $cancelOrder->OrderDetail->foto_iklan = 'none';
            $cancelOrder->OrderDetail->save();
            $cancelOrder->save();
            Storage::delete('\image\\'.$filePath);

            return response()->json([
                'message' => 'Order telah berhasil dibatalkan.',
            ]);
        }

        return response()->json([
            'message' => 'Order gagal dibatalkan.',
        ], 404);
    }

    function CancelExpiredOrder(Request $request, $order_id) {
        try {
            $cancelOrder = OrderData::with("OrderDetail")->findOrFail($order_id);
        } catch (\Throwable $th) {
            $errorMessage = "Order yang anda cari tidak ditemukan.";
            throw new ModelNotFoundException($errorMessage);
        }
        $filePath = $cancelOrder->OrderDetail->foto_iklan;
        $msg = "Dibatalkan oleh sistem.";

        if (Storage::exists('\image\\'.$filePath)){            
            $cancelOrder->OrderDetail->detail_kemajuan = isset($request->detail_kemajuan) ? $request->detail_kemajuan : $msg;
            $cancelOrder->OrderDetail->status_iklan = $cancelOrder->OrderDetail->getStatusIklanValue('Dibatalkan');
            $cancelOrder->OrderDetail->status_pembayaran =  $cancelOrder->OrderDetail->getStatusPembayaranValue('Pembayaran Kedaluwarsa');
            $cancelOrder->OrderDetail->foto_iklan = 'none';
            $cancelOrder->OrderDetail->save();
            $cancelOrder->save();
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
