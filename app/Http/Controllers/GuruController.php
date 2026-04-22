<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::all();
        return view('admin.guru', compact('guru'));
    }

    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('guru', 'public');
        }

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'foto' => $foto
        ]);

        return redirect()->back()->with('success', 'Data guru berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        // VALIDASI
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = $guru->foto;

        if ($request->hasFile('foto')) {

            // HAPUS FOTO LAMA
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }

            // SIMPAN FOTO BARU
            $foto = $request->file('foto')->store('guru', 'public');
        }

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'foto' => $foto
        ]);

        return redirect()->back()->with('success', 'Data guru berhasil diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        // HAPUS FOTO
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->back()->with('success', 'Data guru berhasil dihapus');
    }
}
