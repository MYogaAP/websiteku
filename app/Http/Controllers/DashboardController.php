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

    function LihatPaket(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/AgentPacketList',
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

        $request->session()->put('packet_data', $response->data);
        
        return redirect()->route('paketData');
    }

}
