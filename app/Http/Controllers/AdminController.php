<?php

namespace App\Http\Controllers;
use App\Models\Siswa;
use App\Models\HasilPrediksi;


class AdminController extends Controller
{
    public function dashboard()
{
    $totalSiswa = Siswa::count();
    $totalPrediksi = HasilPrediksi::count();
    $risikoTinggi = HasilPrediksi::where('tingkat_risiko', 'Tinggi')->count();

    $siswaTerbaru = HasilPrediksi::latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalSiswa',
        'totalPrediksi',
        'risikoTinggi',
        'siswaTerbaru'
    ));
}
}
