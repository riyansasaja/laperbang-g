<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class SatkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $token = session('token_api');
        $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/satker');
        if($response->status() == 200){
            $data = $response->json();
            return view('admin.satker', compact('data'));
        }else{
            return redirect()->route('login')->with('error', 'Gagal mengambil data satker!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //simpan di api satker
         $request->validate([
            //required dan text
            'nama_satker' => 'required|string|max:255', 
        ]);

        $token = session('token_api');
        $response = Http::withToken($token)->post('https://api-laperbang.pta-manado.go.id/api/satker', $request->all());
        if($response->status() == 201){
            $data = $response->json();
            $messages = $data['message'] ?? 'Satker berhasil ditambahkan!';
            return redirect()->route('admin.satker')->with('success', $messages);
        }else{
            $data = $response->json();
            $messages = $data['message'] ?? 'Gagal menambahkan satker!';
            return redirect()->route('admin.satker')->with('error', $messages);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255', 
        ]);

        $token = session('token_api');
        $response = Http::withToken($token)->put('https://api-laperbang.pta-manado.go.id/api/satker/' . $id, $request->all());
        
        if($response->status() == 200){
            $data = $response->json();
            $messages = $data['message'] ?? 'Satker berhasil diupdate!';
            return redirect()->route('admin.satker')->with('success', $messages);
        }else{
            $data = $response->json();
            $messages = $data['message'] ?? 'Gagal mengupdate satker!';
            return redirect()->route('admin.satker')->with('error', $messages);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $token = session('token_api');
        $response = Http::withToken($token)->delete('https://api-laperbang.pta-manado.go.id/api/satker/' . $id);
        if($response->status() == 200){
            $data = $response->json();
            $messages = $data['message'] ?? 'Satker berhasil dihapus!';
            return redirect()->route('admin.satker')->with('success', $messages);
        }else{
            $data = $response->json();
            $messages = $data['message'] ?? 'Gagal menghapus satker!';
            return redirect()->route('admin.satker')->with('error', $messages);
        }
    }
}
