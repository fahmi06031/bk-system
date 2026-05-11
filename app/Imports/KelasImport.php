<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kelas([
            'nama_kelas'   => $row['nama_kelas'] ?? $row['Nama Kelas'] ?? null,
            'tingkat'      => $row['tingkat'] ?? $row['Tingkat'] ?? null,
            'jurusan'      => $row['jurusan'] ?? $row['Jurusan'] ?? null,
            'tahun_ajaran' => $row['tahun_ajaran'] ?? $row['Tahun Ajaran'] ?? null,
        ]);
    }
}
