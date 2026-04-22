<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'kelas_id',
        'tanggal_lahir',
        'alamat',
        'foto'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
