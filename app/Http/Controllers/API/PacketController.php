<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\PacketData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserPacketResource;
use App\Http\Controllers\Controller;

class PacketController extends Controller
{
    function GetPacketList() {
        $packets = PacketData::where("hidden", 'no')->simplePaginate(3);
        return UserPacketResource::collection($packets);
    }

    function AgentPacketList() {
        $packets = PacketData::all();
        return response()->json(['data' => $packets]);
    }

    function GetPacket($packet_id) {
        $packet = PacketData::where("packet_id", $packet_id)->get();
        return response()->json(['data' => $packet]);
    }

    function GetPacketColor($packet_id) {
        $packet = PacketData::where("packet_id", $packet_id)->get(['format_warna', 'contoh_foto']);
        return response()->json(['data' => $packet]);
    }

    function UnHidePacket($packet_id) {
        $affected = PacketData::where('packet_id', $packet_id)
        ->update(['hidden'=>'no']);
        return $affected;
    }

    function HidePacket($packet_id) {
        $affected = PacketData::where('packet_id', $packet_id)
        ->update(['hidden'=>'yes']);
        return $affected;
    }

    function AddPacket(Request $request) {
        $validate = $request ->validate([
            'nama_paket' => 'required|max:255|unique:packet_data,nama_paket',
            'tinggi' => 'required|numeric',
            'kolom' => 'required|numeric',
            'format_warna' => 'required|in:fc,bw',
            'hidden' => 'in:yes,no',
            'harga_paket'  => 'numeric',
            'image'=>'required|image',
        ]);

        $fileName = '';
        $extension  = '';
        $fullName = '';
        if($request->image){
            $fileName = Str::random(30);
            $extension =  $request->image->extension();
            $fullName = $fileName.'.'.$extension;

            Storage::putFileAs('image_example', $request->image, $fullName);
        }

        if(!$request->harga_paket){
            $tinggi = $request->tinggi;
            $kolom = $request->kolom;
            $harga = 0;
            $hargaFC = 40000;
            $hargaBW = 30000;

            if($request->format_warna == 'fc'){
                $harga = $tinggi*$kolom*$hargaFC;
            } else {
                $harga = $tinggi*$kolom*$hargaBW;
            }
            
            $request['harga_paket'] = $harga;
        }

        $request['contoh_foto'] = $fullName;
        $packet_data = PacketData::create($request->all());

        return response()->json([
            'message' => 'Packet telah berhasil ditambahkan.',
        ]);
    }

    function DeletePacket($packet_id) {
        $data = PacketData::where('packet_id', $packet_id)->get();

        $filePath = $data[0]->contoh_foto;
        if (Storage::exists('\image_example\\'.$filePath)){
            $affected = PacketData::where('packet_id', $packet_id)
            ->update([
                'nama_paket' => $data[0]->nama_paket."_unavailable_".Str::random(15),
                'contoh_foto' => 'none',
                'hidden' => 'yes',
            ]);
            $affected = PacketData::where('packet_id', $packet_id)
            ->delete();
            Storage::delete('\image_example\\'.$filePath);

            return response()->json([
                'message' => 'Paket telah berhasil dihapus.',
            ]);
        } else {
            return response()->json([
                'message' => 'Sebuah kesalahan telah terjadi.',
                404
            ]);
        }
    }
}
