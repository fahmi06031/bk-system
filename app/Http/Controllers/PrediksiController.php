<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Siswa;
use App\Models\HasilPrediksi;

class PrediksiController extends Controller
{
    /**
     * PROSES PREDIKSI KE FLASK
     */
    public function proses(Request $request)
    {
        // VALIDASI
        $request->validate([
            'siswa_id' => 'required',
            'kehadiran' => 'required|numeric',
            'nilai' => 'required|numeric',
            'sikap' => 'required'
        ]);

        // AMBIL DATA SISWA
        $siswa = Siswa::find($request->siswa_id);

        // mapping sikap (text → angka)
        $sikapMap = [
            'Baik' => 3,
            'Cukup' => 2,
            'Buruk' => 1
        ];

        $sikap = $sikapMap[$request->sikap];

        try {

            // KIRIM KE FLASK
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'kehadiran' => $request->kehadiran,
                'nilai' => $request->nilai,
                'sikap' => $sikap,
            ]);

            // AMBIL HASIL
            $hasil = $response->json();

            // fallback kalau flask error
            $risiko = $hasil['risiko'] ?? 'Tidak Diketahui';

        } catch (\Exception $e) {

            // kalau flask mati
            $risiko = 'Error Flask';
        }

        // 🔥 SIMPAN KE SESSION
        return redirect()->back()->with([
            'hasil_prediksi' => $risiko,
            'nis' => $siswa->nis,
            'nama_siswa' => $siswa->nama,
            'kelas' => optional($siswa->kelas)->nama_kelas
        ]);
    }


    /**
     * SIMPAN HASIL KE DATABASE
     */
    public function simpan(Request $request)
    {
        // VALIDASI (biar aman)
        $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'tingkat_risiko' => 'required'
        ]);

        // SIMPAN KE DB
        HasilPrediksi::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'tgl_prediksi' => now(),
            'tingkat_risiko' => $request->tingkat_risiko,
        ]);

        return redirect('/admin/hasil-prediksi')
            ->with('success', 'Data berhasil disimpan!');
    }
}
