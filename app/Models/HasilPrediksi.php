<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPrediksi extends Model
{

protected $table = 'hasil_prediksi';

protected $fillable = [

'nis',
'nama_siswa',
'kelas',
'tgl_prediksi',
'tingkat_risiko'

];

}
