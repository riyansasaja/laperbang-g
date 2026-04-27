<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginApi extends Controller
{
    //
    public function loginApi(Request $request){
     //form validation
     $request->validate([
        'username' => 'required',
        'password' => 'required',
     ]);
     //response
     $response = Http::post('http://localhost/siwas/public/api/login', [
        'username' => $request->username,
        'password' => $request->password,
     ]);
     //cek apakah login berhasil
     if($response->status() == 200){
        //login berhasil
        $data = $response->json();
        //save token ke session
        session()->put('token_api', $data['token']);
        //redirect ke halaman dashboard
        return redirect()->route('dashboard');
     }else{
        //login gagal
        return redirect()->back()->with('error', 'Login gagal');
     }
     
    }
}
