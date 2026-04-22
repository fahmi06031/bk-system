<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPrediksi;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.cek_risiko');
    }

    public function cari(Request $request)
    {
        $keyword = $request->keyword;

        $hasil = HasilPrediksi::where('nama_siswa', 'like', "%$keyword%")
                    ->orWhere('nis', 'like', "%$keyword%")
                    ->latest()
                    ->first();

        return view('landing.cek_risiko', compact('hasil'));
    }
}
