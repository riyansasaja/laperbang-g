<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DokumenPerkaraController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'perkara_banding_id' => 'required',
            'jenis_dokumen_id' => 'required',
            'file' => 'required|file|max:10240', // Maksimal 10MB
        ]);

        $token = session('token_api');
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi berakhir, silakan login kembali.'
            ], 401);
        }

        $file = $request->file('file');
        
        try {
            $response = Http::withToken($token)
                ->attach(
                    'file', 
                    file_get_contents($file->getRealPath()), 
                    $file->getClientOriginalName()
                )
                ->post('https://api-laperbang.pta-manado.go.id/api/dokumen-perkara', [
                    'perkara_banding_id' => $request->perkara_banding_id,
                    'jenis_dokumen_id' => $request->jenis_dokumen_id,
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil diunggah',
                    'data' => $response->json()
                ]);
            }

            $resData = $response->json();
            $errorMessage = 'Terjadi kesalahan pada server API';

            if (isset($resData['message'])) {
                if (is_array($resData['message'])) {
                    // Jika message berupa array (seperti validasi Laravel)
                    $messages = [];
                    foreach ($resData['message'] as $key => $value) {
                        $messages[] = is_array($value) ? implode(', ', $value) : $value;
                    }
                    $errorMessage = implode(' | ', $messages);
                } else {
                    $errorMessage = $resData['message'];
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah dokumen: ' . $errorMessage,
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
