<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginApi extends Controller
{
   //route untuk view login
   public function login()
   {
       // Jika sudah ada session token_api, redirect sesuai role
       if (session()->has('token_api')) {
           $user = session('user');
           $role = $user['role'] ?? null;
           
           if ($role == 'admin' || $role == 'superadmin') {
               return redirect()->route('admin');
           } else {
               return redirect()->route('pengadilan');
           }
       }

       return view('auth.login');
   }
    //
    public function loginApi(Request $request){
     //form validation
     $request->validate([
        'username' => 'required',
        'password' => 'required',
     ]);
     //response
     $response = Http::post('https://api-laperbang.pta-manado.go.id/api/login', [
        'email' => $request->username,
        'password' => $request->password,
     ]);
     //cek apakah login berhasil
     if($response->status() == 200){
        //login berhasil
        $data = $response->json();
        //save token ke session
        session()->put('token_api', $data['token']);

        //save data user ke session
        session()->put('user', $data['user']);
        
        //cek role
        if($data['role'] == 'admin' || $data['role'] == 'superadmin'){
            return redirect()->route('admin');
        }else{
            return redirect()->route('pengadilan');
        }
     }else{
        //login gagal
        return redirect()->back()->with('error', 'User/Password yang Anda Masukkan Salah!');
     }
     
    }

    public function logout()
    {
        $token = session('token_api');
        
        if ($token) {
            // Hit API logout dengan Bearer Token
           $response = Http::withToken($token)->post('https://api-laperbang.pta-manado.go.id/api/logout');
           //cek response
           if($response->status() == 200){
               //logout berhasil
               session()->forget('token_api');
               session()->forget('user');
               return redirect()->route('login')->with('success', 'Logout berhasil!');
           }else{
               //logout gagal
               return redirect()->route('login')->with('error', 'Logout gagal!');
           }
        }else{
            //token tidak ada
            return redirect()->route('login')->with('error', 'Token tidak ditemukan!');
        }
    }
}
