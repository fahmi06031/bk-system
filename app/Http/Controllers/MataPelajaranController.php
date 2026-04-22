<?php
namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::with('guru')->get();
        $guru = Guru::all();

        return view('admin.mata_pelajaran',compact('mapel','guru'));
    }

    public function store(Request $request)
    {
        MataPelajaran::create([
            'nama_mapel'=>$request->nama_mapel,
            'kode_mapel'=>$request->kode_mapel,
            'guru_id'=>$request->guru_id
        ]);

        return redirect()->back()->with('success','Data mata pelajaran berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        $mapel->update([
            'nama_mapel'=>$request->nama_mapel,
            'kode_mapel'=>$request->kode_mapel,
            'guru_id'=>$request->guru_id
        ]);

        return redirect()->back()->with('success','Data mata pelajaran berhasil diupdate');
    }

    public function destroy($id)
    {
        MataPelajaran::destroy($id);

        return redirect()->back()->with('success','Data mata pelajaran berhasil dihapus');
    }
}
