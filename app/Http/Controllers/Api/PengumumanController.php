<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormat;

class PengumumanController extends Controller
{
    // Mahasiswa & Admin
    public function index()
    {
        $data = Pengumuman::latest()->get();
        return ResponseFormat::success(200, "OK", $data);
    }

    // Admin only
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'isi'   => 'required|string'
        ]);

        $pengumuman = Pengumuman::create([
            'judul' => $request->judul,
            'isi'   => $request->isi
        ]);

        return ResponseFormat::success(201, "Pengumuman berhasil ditambahkan", $pengumuman);
    }

    // Admin only
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'isi'   => 'required|string'
        ]);

        $pengumuman = Pengumuman::find($id);
        if (!$pengumuman) return ResponseFormat::notFound("Pengumuman tidak ditemukan");

        $pengumuman->update([
            'judul' => $request->judul,
            'isi'   => $request->isi
        ]);

        return ResponseFormat::success(200, "Pengumuman berhasil diupdate", $pengumuman);
    }

    // Admin only
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);
        if (!$pengumuman) return ResponseFormat::notFound("Pengumuman tidak ditemukan");

        $pengumuman->delete();

        return ResponseFormat::success(200, "Pengumuman berhasil dihapus");
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);
        if (!$pengumuman) return ResponseFormat::notFound("Pengumuman tidak ditemukan");

        return ResponseFormat::success(200, "OK", $pengumuman);
    }
}
