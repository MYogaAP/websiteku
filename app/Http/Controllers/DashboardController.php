<?php

namespace App\Http\Controllers;

use App\Models\PacketData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index() {
        $data = PacketData::all();
        return response()->json(['data' => $data]);
    }

    function lihatPaket(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/AgentPacketList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer ' .Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $validate = $request ->validate([
            'nama_paket' => 'required|max:255|unique:packet_data,nama_paket',
            'tinggi' => 'required|numeric',
            'kolom' => 'required|numeric',
            'format_warna' => 'required|in:fc,bw',
            'hidden' => 'in:yes,no',
            'harga_paket'  => 'numeric',
            'image'=>'required|image',
        ]);
    }

}
