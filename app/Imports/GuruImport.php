<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Guru([
            'nip'   => $row['nip'] ?? $row['NIP'] ?? null,
            'nama'  => $row['nama'] ?? $row['Nama'] ?? null,
            'email' => $row['email'] ?? $row['Email'] ?? null,
            'no_hp' => $row['no_hp'] ?? $row['No Hp'] ?? $row['No_Hp'] ?? null,
        ]);
    }
}
