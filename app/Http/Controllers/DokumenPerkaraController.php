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

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah dokumen: ' . ($response->json()['message'] ?? 'Terjadi kesalahan pada server API'),
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
