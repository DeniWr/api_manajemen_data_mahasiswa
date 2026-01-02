<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormat;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Mahasiswa;
use App\Models\User;
// Auth
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function login(Request $r)
    {
        $cred = $r->only('nim', 'password');

        if (!Auth::attempt($cred)) {
            return ResponseFormat::unauthorized("NIM / Password salah Auth");
        }
        if (!$token = JWTAuth::attempt($cred)) {
            return ResponseFormat::unauthorized("NIM / Password salah");
        }

        return ResponseFormat::success(
            200,
            "Login berhasil",
            ResponseFormat::success(200, "", [
                'token' => $token,
                'user' => Auth::user()
            ])
        );
    }

    public function me()
    {
        return ResponseFormat::success(200, "OK", User::with('mahasiswa')->find(Auth::id()));
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            $expiry = Carbon::now()->addMinutes(config('jwt.ttl'));
            return ResponseFormat::success(200, "Token refreshed successfully", ['token' => $newToken, 'expires_at' => $expiry->toDateTimeString()]);
        } catch (JWTException $e) {
            return ResponseFormat::unauthorized("Token is invalid");
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();
            return ResponseFormat::success(200, "User logged out successfully");
        } catch (JWTException $e) {
            return ResponseFormat::unauthorized("Token is invalid");
        }
    }

    public function register(Request $r)
    {
        $user = User::create([
            'nim' => $r->nim,
            'name' => $r->name,
            'password' => Hash::make($r->password),
            'role' => '2',
            'status' => 'pending'
        ]);

        Mahasiswa::create(['user_id' => $user->id]);

        return ResponseFormat::success(200, "Registrasi berhasil");
    }
}
