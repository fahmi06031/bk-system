<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function pelanggarans()
    {
        return $this->hasMany(PelanggaranSiswa::class, 'siswa_id');
    }

    public function catatanKonselings()
    {
        return $this->hasMany(CatatanKonseling::class, 'siswa_id');
    }

    public function hasilPrediksis()
    {
        return $this->hasMany(HasilPrediksi::class, 'siswa_id');
    }
}
