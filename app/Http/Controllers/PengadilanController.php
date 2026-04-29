<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PengadilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            //ambil data perkara dari user yang login
            $token = session('token_api');
            $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/perkara');
            if($response->status() == 200){
                $data = $response->json();
                return view('master.pengadilan.index', compact('data'));   
            }else{
               dd($response->status()) ;
            }       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi inputan
        $request->validate([
            'no_perkara' => 'required',
            'jenis_perkara_id' => 'required',
            'pihak_p' => 'required',
            'hp_pihak_p' => 'required',
            'pihak_t' => 'required',
            'hp_pihak_t' => 'required',
        ]);
        
        //terima inputan request
        $token = session('token_api');
        $response = Http::withToken($token)->post('https://api-laperbang.pta-manado.go.id/api/perkara', [
            'no_perkara' => $request->no_perkara,
            'jenis_perkara_id' => $request->jenis_perkara_id,
            'pihak_p' => $request->pihak_p,
            'hp_pihak_p' => $request->hp_pihak_p,
            'pihak_t' => $request->pihak_t,
            'hp_pihak_t' => $request->hp_pihak_t,
        ]);
        if($response->status() == 201){
            return redirect()->route('pengadilan')->with('success', 'Data Berhasil Ditambahkan');
        }else{
            return redirect()->back()->with('error', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            $token = session('token_api');
            $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/perkara/'.$id);
            if($response->status() == 200){
                $data = $response->json();
                return view('master.pengadilan.show', compact('data'));   
            }else{
                return redirect()->back()->with('error', 'Gagal mengambil data perkara!');
            }       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $token = session('token_api');
            $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/perkara/'.$id);
            if($response->status() == 200){
                $data = $response->json();
                return view('master.pengadilan.edit', compact('data'));   
            }else{
                return redirect()->back()->with('error', 'Gagal mengambil data perkara!');
            }       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $token = session('token_api');
            $response = Http::withToken($token)->put('https://api-laperbang.pta-manado.go.id/api/perkara/'.$id, [
                'no_perkara' => $request->no_perkara,
                'jenis_perkara_id' => $request->jenis_perkara_id,
                'pihak_p' => $request->pihak_p,
                'hp_pihak_p' => $request->hp_pihak_p,
                'pihak_t' => $request->pihak_t,
                'hp_pihak_t' => $request->hp_pihak_t,
            ]);

            if($response->status() == 200){
                return redirect()->route('pengadilan')->with('success', 'Data Berhasil Diperbarui');
            }else{
                return redirect()->back()->with('error', 'Data Gagal Diperbarui');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $token = session('token_api');
            $response = Http::withToken($token)->delete('https://api-laperbang.pta-manado.go.id/api/perkara/'.$id);
            
            if($response->status() == 200){
                return redirect()->route('pengadilan')->with('success', 'Data Berhasil Dihapus');
            }else{
                return redirect()->back()->with('error', 'Data Gagal Dihapus');
            }
    }
}
