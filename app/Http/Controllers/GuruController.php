<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;

class GuruController extends Controller
{
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048'
            ], [
                'file.required' => 'File harus dipilih',
                'file.mimes' => 'Format file harus XLSX, XLS, atau CSV',
                'file.max' => 'Ukuran file maksimal 2MB',
            ]);

            Excel::import(new GuruImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data guru berhasil diimport!');
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            return redirect()->back()->with('csrf_error', 'Sesi telah berakhir. Silakan coba lagi.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
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
        $guru = Guru::withCount('mataPelajarans')->findOrFail($id);

        // Cek apakah guru masih mengajar mapel
        if ($guru->mata_pelajarans_count > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus guru "' . $guru->nama . '" karena masih mengajar ' . $guru->mata_pelajarans_count . ' mata pelajaran.');
        }

        // HAPUS FOTO
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->back()->with('success', 'Data guru berhasil dihapus');
    }
}
