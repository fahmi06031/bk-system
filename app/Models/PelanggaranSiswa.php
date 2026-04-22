<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelanggaranSiswa extends Model
{

protected $table = 'pelanggaran_siswa';

protected $fillable = [
'siswa_id',
'jenis_pelanggaran_id',
'tanggal',
'keterangan'
];

public function siswa()
{
return $this->belongsTo(Siswa::class);
}

public function jenisPelanggaran()
{
return $this->belongsTo(JenisPelanggaran::class,'jenis_pelanggaran_id');
}

}
