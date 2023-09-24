<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PacketData;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PacketController extends Controller
{
    function AddPacket(Request $request) {
        if (Auth::user()->role == 'agent'){
            $validate = $request ->validate([
                'nama_paket' => 'required|max:255|unique:packet_data,nama_paket',
                'tinggi' => 'required|numeric',
                'kolom' => 'required|numeric',
                'format_warna' => 'required|in:fc,bw',
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

                if($request->format_warna == 'fc'){
                    $harga = $tinggi*$kolom*40000;
                } else {
                    $harga = $tinggi*$kolom*30000;
                }
            }
    
            $request['contoh_foto'] = $fullName;
            $request['harga_paket'] = $harga;
            $packet_data = PacketData::create($request->all());
    
            return response()->json([
                'message' => 'Packet has been succesfully made.',
            ]);
        }
        
        return response()->json([
            'message' => 'You are not an agent.',
        ]);
    }
}
