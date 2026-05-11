<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MataPelajaranImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MataPelajaran([
            'nama_mapel' => $row['nama_mapel'] ?? $row['Nama Mapel'] ?? null,
            'kode_mapel' => $row['kode_mapel'] ?? $row['Kode Mapel'] ?? null,
            'guru_id'    => $row['guru_id'] ?? $row['Guru ID'] ?? null,
        ]);
    }
}
