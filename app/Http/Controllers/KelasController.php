<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::latest()->get();
        return view('admin.kelas', compact('kelas'));
    }

    public function store(Request $request)
    {
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'tahun_ajaran' => $request->tahun_ajaran
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'tahun_ajaran' => $request->tahun_ajaran
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Kelas::destroy($id);

        return redirect()->back();
    }
}
