@extends('layouts.admin')

@section('content')

<div class="head-title">

<div class="left">
<h1>Data Mata Pelajaran</h1>
</div>

<div style="display:flex;gap:10px;">
<button class="btn-download" onclick="ImportModalManager.openModal('modalImportMapel')" style="background: #28a745;">
<i class='bx bx-import'></i>
<span class="text">Import Excel</span>
</button>
<button class="btn-download" onclick="openTambahMapel()">
<i class='bx bx-plus'></i>
<span class="text">Tambah Mapel</span>
</button>
</div>

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



@endsection

@section('modals')
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

{{-- MODAL IMPORT MAPEL --}}
<div id="modalImportMapel" class="modal">
<div class="modal-content">
<div class="modal-header">
<h2>Import Data Mata Pelajaran (Excel)</h2>
<button type="button" onclick="ImportModalManager.closeModal('modalImportMapel')" class="modal-close">
<i class='bx bx-x'></i>
</button>
</div>

<div style="background: #e8f4f8; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3C91E6;">
  <div style="font-weight: 600; margin-bottom: 8px; color: #1a5a7a;">Format yang Diperlukan:</div>
  <div style="font-size: 13px; color: #333; line-height: 1.6;">
    <strong>Kolom:</strong> Nama Mapel | Kode Mapel | Guru ID<br>
    <strong>Contoh:</strong> Matematika | MAT | 1<br>
    <strong>Catatan:</strong> Guru ID harus ada di database
  </div>
  <a href="{{ url('templates/template_mata_pelajaran.xlsx') }}" class="btn-download" style="display: inline-block; margin-top: 10px; background: #3C91E6; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">
    <i class='bx bx-download'></i> Download Template
  </a>
</div>

<form method="POST" action="/admin/mata-pelajaran/import" enctype="multipart/form-data" onsubmit="ImportModalManager.handleSubmit(this)">
@csrf
<div class="form-grid">
<div class="form-group full">
<label>File Excel (.xlsx, .xls, .csv)</label>
<input type="file" name="file" required accept=".xlsx, .xls, .csv">
</div>
</div>
<div class="modal-footer">
<button type="button" onclick="ImportModalManager.closeModal('modalImportMapel')" class="btn-cancel">
Batal
</button>
<button type="submit" class="btn-save" style="background: #28a745;">
Import
</button>
</div>
</form>
</div>
</div>

@endsection
