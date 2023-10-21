<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataLinkerController extends Controller
{
    function SendToDetailUkuran(Request $request) {
        $data = [
            "nama_instansi" => $request->nama_instansi,
            "mulai_iklan" => $request->mulai_iklan,
            "akhir_iklan" => $request->akhir_iklan,
            "deskripsi_iklan" => $request->deskripsi_iklan,
            "email_instansi" => $request->email_instansi,
        ];

        $request->session()->put('form_data', $data);

        return redirect()->route('detailukuran');
    }
}
