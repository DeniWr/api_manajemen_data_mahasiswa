<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormat;
use App\Models\User;

class AdminController extends Controller
{
    public function mahasiswa(){
        return ResponseFormat::success(200,"OK",
            User::where('role','mahasiswa')->with('mahasiswa')->get()
        );
    }

    public function activate($id){
        $u = User::find($id);
        if(!$u) return ResponseFormat::notFound();

        $u->is_active = true;
        $u->save();

        return ResponseFormat::success(200,"Mahasiswa diaktifkan", $u);
    }

    public function deactivate($id){
        $u = User::find($id);
        if(!$u) return ResponseFormat::notFound();

        $u->is_active = false;
        $u->save();

        return ResponseFormat::success(200,"Mahasiswa diblokir", $u);
    }

}
