<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data siswa berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
    public function index()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();

        return view('admin.siswa', compact('siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        // DEBUG (aktifkan kalau mau cek)
        // dd($request->all());

        // VALIDASI
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'nama',
            'jenis_kelamin',
            'kelas_id',
            'tanggal_lahir',
            'alamat'
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

        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'nama',
            'jenis_kelamin',
            'kelas_id',
            'tanggal_lahir',
            'alamat'
        ]);

        // FOTO BARU
        if ($request->hasFile('foto')) {

            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return redirect()->back()->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::withCount(['pelanggarans', 'catatanKonselings', 'hasilPrediksis'])->findOrFail($id);

        $related = [];
        if ($siswa->pelanggarans_count > 0) {
            $related[] = $siswa->pelanggarans_count . ' data pelanggaran';
        }
        if ($siswa->catatan_konselings_count > 0) {
            $related[] = $siswa->catatan_konselings_count . ' catatan konseling';
        }
        if ($siswa->hasil_prediksis_count > 0) {
            $related[] = $siswa->hasil_prediksis_count . ' hasil prediksi';
        }

        if (!empty($related)) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus siswa "' . $siswa->nama . '" karena masih memiliki: ' . implode(', ', $related) . '. Hapus data terkait terlebih dahulu.');
        }

        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus');
    }
}
