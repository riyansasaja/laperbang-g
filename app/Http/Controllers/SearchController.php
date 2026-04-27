<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    //
    public function search(Request $request){
     $request->validate([
        'nomor_perkara' => 'required',
        'tahun_perkara' => 'required',
     ]);
     
    //http request
    $response = Http::post('https://api-laperbang.pta-manado.go.id/api/status-perkara', [
        'nomor_perkara' => $request->nomor_perkara,
        'tahun_perkara' => $request->tahun_perkara,
    ]);
    //jika respon 404
    if($response->status() == 404){
        return redirect()->back()->with('error', 'Data perkara tidak ditemukan (404).');
    }

    //response json
    $dataperkara = $response->json();
    //jika $dataperkara kosong kirim pesan error ke view
    if($dataperkara == null){
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
    //kirim response ke view
    return view('search.index', compact('dataperkara'));  

    }
}
