<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();

        return view('admin.siswa', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'nama',
            'jenis_kelamin',
            'kelas_id'
        ]);

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create($data);

        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // VALIDASI
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'nama',
            'jenis_kelamin',
            'kelas_id'
        ]);

        // CEK FOTO BARU
        if ($request->hasFile('foto')) {

            // HAPUS FOTO LAMA
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            // SIMPAN FOTO BARU
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->back()->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // HAPUS FOTO
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus');
    }
}
