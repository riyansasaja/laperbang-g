<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class AdminController extends Controller
{
    //index
    public function index()
    {
        return view('admin.index');
    }

    //Show all Users
    public function users()
    {
     //get http https://api-laperbang.pta-manado.go.id/api/user
     $token = session('token_api');
     $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/user');
     if($response->status() == 200){
        $data = $response->json();
        return view('admin.users', compact('data'));
     }else{
        return redirect()->route('login')->with('error', 'Gagal mengambil data user!');
     }
    }

    //show all satker
    public function satker()
    {
        $token = session('token_api');
        $response = Http::withToken($token)->get('https://api-laperbang.pta-manado.go.id/api/satker');
        if($response->status() == 200){
            $data = $response->json();
            return view('admin.satker', compact('data'));
        }else{
            return redirect()->route('login')->with('error', 'Gagal mengambil data satker!');
        }
    }
}
