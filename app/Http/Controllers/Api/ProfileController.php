<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return ResponseFormat::success(
            200,
            "OK",
            Auth::user()->mahasiswa
        );
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if(!$user->mahasiswa){
            return ResponseFormat::notFound();
        }

        $user->mahasiswa->update($request->all());

        return ResponseFormat::success(200, "Profil berhasil diupdate");
    }
}
