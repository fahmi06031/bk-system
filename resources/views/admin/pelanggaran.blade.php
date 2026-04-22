@extends('layouts.admin')

@section('content')

<div class="head-title">

<div class="left">
<h1>Data Pelanggaran Siswa</h1>
</div>

<button class="btn-download" onclick="openTambahPelanggaran()">
<i class='bx bx-plus'></i>
<span class="text">Tambah Pelanggaran</span>
</button>

</div>



<div class="table-data">
<div class="order">

<table>

<thead>

<tr>
<th>Siswa</th>
<th>Jenis Pelanggaran</th>
<th>Tanggal</th>
<th>Keterangan</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

@foreach($pelanggaran as $p)

<tr>

<td>{{ $p->siswa->nama }}</td>

<td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>

<td>{{ $p->tanggal }}</td>

<td>{{ $p->keterangan }}</td>

<td>

<form action="/admin/pelanggaran/{{$p->id}}" method="POST">

@csrf
@method('DELETE')

<button style="background:red;color:white;border:none;padding:5px 10px;border-radius:6px;">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>



{{-- MODAL TAMBAH PELANGGARAN --}}

<div id="modalTambahPelanggaran" class="modal">

<div class="modal-content">

<div class="modal-header">

<h2>Tambah Pelanggaran</h2>

<button onclick="closeModalPelanggaran()" class="modal-close">
<i class='bx bx-x'></i>
</button>

</div>


<form method="POST" action="/admin/pelanggaran">

@csrf


<div class="form-grid">

<div class="form-group">

<label>Siswa</label>

<select name="siswa_id">

@foreach($siswa as $s)

<option value="{{$s->id}}">
{{$s->nama}}
</option>

@endforeach

</select>

</div>


<div class="form-group">

<label>Jenis Pelanggaran</label>

<select name="jenis_pelanggaran_id">

@foreach($jenis as $j)

<option value="{{$j->id}}">
{{$j->nama_pelanggaran}}
</option>

@endforeach

</select>

</div>


<div class="form-group">

<label>Tanggal</label>

<input type="date" name="tanggal">

</div>


<div class="form-group full">

<label>Keterangan</label>

<textarea name="keterangan" rows="3"></textarea>

</div>

</div>


<div class="modal-footer">

<button type="button" onclick="closeModalPelanggaran()" class="btn-cancel">
Batal
</button>

<button type="submit" class="btn-save">
<i class='bx bx-save'></i>
Simpan
</button>

</div>

</form>

</div>

</div>

@endsection
