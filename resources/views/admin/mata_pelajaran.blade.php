@extends('layouts.admin')

@section('content')

<div class="head-title">

<div class="left">
<h1>Data Mata Pelajaran</h1>
</div>

<button class="btn-download" onclick="openTambahMapel()">
<i class='bx bx-plus'></i>
<span class="text">Tambah Mapel</span>
</button>

</div>



<div class="table-data">
<div class="order">

<table>

<thead>
<tr>
<th>Kode</th>
<th>Nama Mapel</th>
<th>Guru Pengampu</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($mapel as $m)

<tr>

<td>{{$m->kode_mapel}}</td>
<td>{{$m->nama_mapel}}</td>
<td>{{$m->guru->nama ?? '-'}}</td>

<td style="display:flex;gap:10px;">

<button
onclick="openEditMapel(
'{{$m->id}}',
'{{$m->kode_mapel}}',
'{{$m->nama_mapel}}',
'{{$m->guru_id}}'
)"
style="background:#3C91E6;color:white;border:none;padding:5px 10px;border-radius:6px;">
Edit
</button>


<form action="/admin/mata-pelajaran/{{$m->id}}" method="POST">

@csrf
@method('DELETE')

<button type="button"
onclick="confirmDelete(this)"
style="background:red;color:white;border:none;padding:5px 10px;border-radius:6px;">
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



{{-- MODAL TAMBAH MAPEL --}}

<div id="modalTambahMapel" class="modal">

<div class="modal-content">

<div class="modal-header">

<h2>Tambah Mata Pelajaran</h2>

<button onclick="closeModalMapel()" class="modal-close">
<i class='bx bx-x'></i>
</button>

</div>


<form method="POST" action="/admin/mata-pelajaran">

@csrf

<div class="form-grid">

<div class="form-group">
<label>Kode Mapel</label>
<input type="text" name="kode_mapel" placeholder="Contoh: MTK01">
</div>

<div class="form-group">
<label>Nama Mapel</label>
<input type="text" name="nama_mapel" placeholder="Contoh: Matematika">
</div>

<div class="form-group full">
<label>Guru Pengampu</label>

<select name="guru_id">

@foreach($guru as $g)

<option value="{{$g->id}}">
{{$g->nama}}
</option>

@endforeach

</select>

</div>

</div>


<div class="modal-footer">

<button type="button" onclick="closeModalMapel()" class="btn-cancel">
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



{{-- MODAL EDIT MAPEL --}}

<div id="modalEditMapel" class="modal">

<div class="modal-content">

<div class="modal-header">

<h2>Edit Mata Pelajaran</h2>

<button onclick="closeModalMapel()" class="modal-close">
<i class='bx bx-x'></i>
</button>

</div>


<form id="formEditMapel" method="POST">

@csrf
@method('PUT')

<div class="form-grid">

<div class="form-group">
<label>Kode Mapel</label>
<input type="text" id="edit_kode" name="kode_mapel">
</div>

<div class="form-group">
<label>Nama Mapel</label>
<input type="text" id="edit_nama" name="nama_mapel">
</div>

<div class="form-group full">
<label>Guru Pengampu</label>

<select id="edit_guru" name="guru_id">

@foreach($guru as $g)

<option value="{{$g->id}}">
{{$g->nama}}
</option>

@endforeach

</select>

</div>

</div>


<div class="modal-footer">

<button type="button" onclick="closeModalMapel()" class="btn-cancel">
Batal
</button>

<button type="submit" class="btn-save">
Update
</button>

</div>

</form>

</div>

</div>

@endsection
