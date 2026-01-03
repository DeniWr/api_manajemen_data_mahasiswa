<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ResponseFormat;

class ProfileController extends Controller
{
    public function show()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return ResponseFormat::success(200, "OK", $user->mahasiswa);
    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user->mahasiswa) {
            return ResponseFormat::notFound();
        }

        $user->mahasiswa->update(
            $request->only(['jurusan', 'angkatan', 'alamat'])
        );

        $user->mahasiswa->save();

        return ResponseFormat::success(200, "Profil berhasil diupdate", $user->mahasiswa);
    }
}
