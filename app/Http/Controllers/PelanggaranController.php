<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelanggaranSiswa;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;

class PelanggaranController extends Controller
{

public function index()
{

$pelanggaran = PelanggaranSiswa::with('siswa','jenisPelanggaran')->latest()->get();

$siswa = Siswa::all();
$jenis = JenisPelanggaran::all();

return view('admin.pelanggaran',compact(
'pelanggaran',
'siswa',
'jenis'
));

}


public function store(Request $request)
{

PelanggaranSiswa::create([

'siswa_id'=>$request->siswa_id,
'jenis_pelanggaran_id'=>$request->jenis_pelanggaran_id,
'tanggal'=>$request->tanggal,
'keterangan'=>$request->keterangan

]);

return redirect()->back();

}


public function destroy($id)
{

PelanggaranSiswa::destroy($id);

return redirect()->back();

}

}
