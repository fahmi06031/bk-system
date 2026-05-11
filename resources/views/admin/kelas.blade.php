@extends('layouts.admin')

@section('content')

<div class="head-title">

<div class="left">
<h1>Data Kelas</h1>
</div>

<div style="display:flex;gap:10px;">
<button class="btn-download" onclick="ImportModalManager.openModal('modalImportKelas')" style="background: #28a745;">
<i class='bx bx-import'></i>
<span class="text">Import Excel</span>
</button>
<button class="btn-download" onclick="openTambahKelas()">
<i class='bx bx-plus'></i>
<span class="text">Tambah Kelas</span>
</button>
</div>

</div>



<div class="table-data">
<div class="order">

<table>

<thead>
<tr>
<th>Nama Kelas</th>
<th>Tingkat</th>
<th>Jurusan</th>
<th>Tahun Ajaran</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($kelas as $k)

<tr>

<td>{{$k->nama_kelas}}</td>
<td>{{$k->tingkat}}</td>
<td>{{$k->jurusan}}</td>
<td>{{$k->tahun_ajaran}}</td>

<td style="display:flex;gap:10px;">

<button
onclick="openEditKelas(
'{{$k->id}}',
'{{$k->nama_kelas}}',
'{{$k->tingkat}}',
'{{$k->jurusan}}',
'{{$k->tahun_ajaran}}'
)"
style="background:#3C91E6;color:white;border:none;padding:5px 10px;border-radius:6px;">
Edit
</button>


<form action="/admin/kelas/{{$k->id}}" method="POST">

@csrf
@method('DELETE')

<button type="button" onclick="confirmDelete(this)" style="background:red;color:white;border:none;padding:5px 10px;border-radius:6px;">
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
{{-- MODAL TAMBAH KELAS --}}

<div id="modalTambahKelas" class="modal">

<div class="modal-content">

<div class="modal-header">

<h2>Tambah Data Kelas</h2>

<button onclick="closeModalKelas()" class="modal-close">
<i class='bx bx-x'></i>
</button>

</div>


<form method="POST" action="/admin/kelas">

@csrf

<div class="form-grid">

<div class="form-group">
<label>Nama Kelas</label>
<input type="text" name="nama_kelas" placeholder="Contoh: XII RPL">
</div>

<div class="form-group">
<label>Tingkat</label>
<input type="number" name="tingkat" placeholder="10 / 11 / 12">
</div>

<div class="form-group">
<label>Jurusan</label>
<input type="text" name="jurusan" placeholder="RPL / TKJ / AKL">
</div>

<div class="form-group">
<label>Tahun Ajaran</label>
<input type="text" name="tahun_ajaran" placeholder="2024/2025">
</div>

</div>


<div class="modal-footer">

<button type="button" onclick="closeModalKelas()" class="btn-cancel">
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



{{-- MODAL EDIT KELAS --}}

<div id="modalEditKelas" class="modal">

<div class="modal-content">

<div class="modal-header">

<h2>Edit Data Kelas</h2>

<button onclick="closeModalKelas()" class="modal-close">
<i class='bx bx-x'></i>
</button>

</div>


<form id="formEditKelas" method="POST">

@csrf
@method('PUT')

<div class="form-grid">

<div class="form-group">
<label>Nama Kelas</label>
<input type="text" id="edit_nama_kelas" name="nama_kelas">
</div>

<div class="form-group">
<label>Tingkat</label>
<input type="number" id="edit_tingkat" name="tingkat">
</div>

<div class="form-group">
<label>Jurusan</label>
<input type="text" id="edit_jurusan" name="jurusan">
</div>

<div class="form-group">
<label>Tahun Ajaran</label>
<input type="text" id="edit_tahun_ajaran" name="tahun_ajaran">
</div>

</div>


<div class="modal-footer">

<button type="button" onclick="closeModalKelas()" class="btn-cancel">
Batal
</button>

<button type="submit" class="btn-save">
Update
</button>

</div>

</form>

</div>

</div>

{{-- MODAL IMPORT KELAS --}}
<div id="modalImportKelas" class="modal">
<div class="modal-content">
<div class="modal-header">
<h2>Import Data Kelas (Excel)</h2>
<button type="button" onclick="ImportModalManager.closeModal('modalImportKelas')" class="modal-close">
<i class='bx bx-x'></i>
</button>
</div>

<div style="background: #e8f4f8; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3C91E6;">
  <div style="font-weight: 600; margin-bottom: 8px; color: #1a5a7a;">Format yang Diperlukan:</div>
  <div style="font-size: 13px; color: #333; line-height: 1.6;">
    <strong>Kolom:</strong> Nama Kelas | Tingkat | Jurusan | Tahun Ajaran<br>
    <strong>Contoh:</strong> X-A | 10 | IPA | 2025/2026<br>
    <strong>Catatan:</strong> Tingkat: 10, 11, atau 12
  </div>
  <a href="{{ url('templates/template_kelas.xlsx') }}" class="btn-download" style="display: inline-block; margin-top: 10px; background: #3C91E6; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">
    <i class='bx bx-download'></i> Download Template
  </a>
</div>

<form method="POST" action="/admin/kelas/import" enctype="multipart/form-data" onsubmit="ImportModalManager.handleSubmit(this)">
@csrf
<div class="form-grid">
<div class="form-group full">
<label>File Excel (.xlsx, .xls, .csv)</label>
<input type="file" name="file" required accept=".xlsx, .xls, .csv">
</div>
</div>
<div class="modal-footer">
<button type="button" onclick="ImportModalManager.closeModal('modalImportKelas')" class="btn-cancel">
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
