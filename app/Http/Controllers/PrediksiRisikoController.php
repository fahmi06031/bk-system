<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class PrediksiRisikoController extends Controller
{

public function index()
{

$siswa = Siswa::all();

return view('admin.prediksi_risiko',compact('siswa'));

}


public function proses(Request $request)
{

// nanti diisi logic ML

return back()->with('hasil_prediksi','Tinggi');

}


public function simpan(Request $request)
{

// nanti disimpan ke tabel hasil_prediksi

return back()->with('success','Hasil prediksi disimpan');

}

}
