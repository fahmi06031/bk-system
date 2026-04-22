<?php

namespace App\Http\Controllers;

use App\Models\HasilPrediksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HasilPrediksiController extends Controller
{
    /**
     * TAMPIL DATA
     */
    public function index()
    {
        $prediksi = HasilPrediksi::latest()->get();

        return view('admin.hasil_prediksi', compact('prediksi'));
    }

    /**
     * SIMPAN DATA
     */
    public function simpan(Request $request)
    {
        // ✅ VALIDASI (WAJIB)
        $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'tingkat_risiko' => 'required'
        ]);

        // ✅ MAPPING AMAN
        $map = [
            'Aman' => 'Rendah',
            'Waspada' => 'Sedang',
            'Berisiko' => 'Tinggi'
        ];

        $tingkat = $map[$request->tingkat_risiko] ?? 'Tidak Diketahui';

        // ✅ SIMPAN
        HasilPrediksi::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tgl_prediksi' => Carbon::now(),
            'tingkat_risiko' => $tingkat
        ]);

        return redirect('/admin/hasil-prediksi')
            ->with('success', 'Data berhasil disimpan');
    }

    /**
     * HAPUS DATA
     */
    public function destroy($id)
    {
        HasilPrediksi::destroy($id);

        return redirect()->back()
            ->with('success', 'Data berhasil dihapus');
    }
}
