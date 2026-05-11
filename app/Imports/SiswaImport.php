<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Ambil nilai jenis_kelamin dari berbagai kemungkinan kolom
        $jk = $row['jenis_kelamin'] ?? $row['jenis kelamin'] ?? $row['Jenis Kelamin'] ?? $row['JENIS KELAMIN'] ?? $row['L/P'] ?? null;

        // Konversi nilai jenis_kelamin: "Laki-laki" → "L", "Perempuan" → "P"
        if (is_string($jk)) {
            $jk = trim($jk);
            $jkLower = strtolower($jk);
            if (in_array($jkLower, ['laki-laki', 'laki', 'l', 'pria', 'male'])) {
                $jk = 'L';
            } elseif (in_array($jkLower, ['perempuan', 'p', 'wanita', 'female'])) {
                $jk = 'P';
            }
        }

        return new Siswa([
            'nis'           => $row['nis'] ?? $row['NIS'] ?? null,
            'nama'          => $row['nama'] ?? $row['Nama'] ?? null,
            'jenis_kelamin' => $jk,
            'kelas_id'      => $row['kelas_id'] ?? $row['Kelas ID'] ?? $row['kelas id'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? $row['Tanggal Lahir'] ?? $row['tanggal lahir'] ?? null,
            'alamat'        => $row['alamat'] ?? $row['Alamat'] ?? null,
        ]);
    }

    /**
    * Validasi rules
    */
    public function rules(): array
    {
        return [
            'nis' => 'required',
            'nama' => 'required',
        ];
    }
}
