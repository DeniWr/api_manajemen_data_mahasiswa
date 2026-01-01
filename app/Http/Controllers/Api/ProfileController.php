<?php

use App\Helpers\ResponseFormat;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show(){
        return ResponseFormat::success(200,"OK", auth()->user()->mahasiswa);
    }

    public function update(Request $r){
        auth()->user()->mahasiswa->update($r->all());
        return ResponseFormat::success(200,"Profil diupdate");
    }
}

