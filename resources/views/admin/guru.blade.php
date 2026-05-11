@extends('layouts.admin')

@section('content')

<div class="head-title">

  <div class="left">
    <h1>Data Guru</h1>
  </div>

  <div style="display:flex;gap:10px;">
    <button class="btn-download" onclick="ImportModalManager.openModal('modalImportGuru')" style="background: #28a745;">
      <i class='bx bx-import'></i>
      <span class="text">Import Excel</span>
    </button>
    <button class="btn-download" onclick="openTambahGuru()">
      <i class='bx bx-plus'></i>
      <span class="text">Tambah Guru</span>
    </button>
  </div>

</div>


<div class="table-data">
  <div class="order">

    <table>

      <thead>
        <tr>
          <th>Foto</th>
          <th>NIP</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>

        @foreach($guru as $g)

        <tr>

          <td>

            @if($g->foto)
            <img src="{{ asset('storage/'.$g->foto) }}" width="40" style="border-radius:50%; width:36px; height:36px; object-fit:cover;">
            @else
            <div class="avatar-inisial table-avatar" style="background: {{ '#' . substr(md5($g->nama), 0, 6) }};">
              {{ substr($g->nama, 0, 1) }}
            </div>
            @endif

          </td>

          <td>{{$g->nip}}</td>
          <td>{{$g->nama}}</td>
          <td>{{$g->email}}</td>
          <td>{{$g->no_hp}}</td>

          <td style="display:flex;gap:10px;">


            <button onclick="openEditGuru(
'{{$g->id}}',
'{{$g->nip}}',
'{{$g->nama}}',
'{{$g->email}}',
'{{$g->no_hp}}',
'{{$g->foto}}'
)"
style="background:#3C91E6;color:white;border:none;padding:5px 10px;border-radius:6px;">
  Edit
</button>


            <form action="/admin/guru/{{$g->id}}" method="POST">

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
{{-- MODAL TAMBAH GURU --}}

<div id="modalTambahGuru" class="modal">

  <div class="modal-content">

    <div class="modal-header">

      <h2>Tambah Data Guru</h2>

      <button onclick="closeModalGuru()" class="modal-close">
        <i class='bx bx-x'></i>
      </button>

    </div>


    <form method="POST" action="/admin/guru" enctype="multipart/form-data">

      @csrf


      <div class="form-grid">

        <div class="form-group">
          <label>NIP</label>
          <input type="text" name="nip" placeholder="Masukkan NIP">
        </div>

        <div class="form-group">
          <label>Nama Guru</label>
          <input type="text" name="nama" placeholder="Masukkan Nama Guru">
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="Masukkan Email">
        </div>

        <div class="form-group">
          <label>No HP</label>
          <input type="text" name="no_hp" placeholder="Masukkan No HP">
        </div>

        <div class="form-group full">
          <label>Foto Guru</label>
          <input type="file" name="foto">
        </div>

      </div>


      <div class="modal-footer">

        <button type="button" onclick="closeModalGuru()" class="btn-cancel">
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


{{-- MODAL VIEW GURU --}}

<div id="modalViewGuru" class="modal">

  <div class="modal-content">

    <div class="modal-header">

      <h2>Detail Data Guru</h2>

      <button onclick="closeModalGuru()" class="modal-close">
        <i class='bx bx-x'></i>
      </button>

    </div>


    <div class="form-grid">

      <div class="form-group full" style="text-align:center;">
        <img id="view_foto" src="" width="100" style="border-radius:10px;">
      </div>

      <div class="form-group">
        <label>NIP</label>
        <input type="text" id="view_nip" readonly>
      </div>

      <div class="form-group">
        <label>Nama Guru</label>
        <input type="text" id="view_nama" readonly>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="text" id="view_email" readonly>
      </div>

      <div class="form-group">
        <label>No HP</label>
        <input type="text" id="view_no_hp" readonly>
      </div>

    </div>


    <div class="modal-footer">

      <button type="button" onclick="closeModalGuru()" class="btn-cancel">
        Tutup
      </button>

    </div>

  </div>

</div>

{{-- MODAL EDIT GURU --}}

<div id="modalEditGuru" class="modal">

  <div class="modal-content">

    <div class="modal-header">
      <h2>Edit Data Guru</h2>

      <button onclick="closeModalGuru()" class="modal-close">
        <i class='bx bx-x'></i>
      </button>
    </div>

    <form id="formEditGuru" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-grid">

        <!-- FOTO -->
        <div class="form-group full" style="text-align:center;">
          <label>Foto Guru</label><br>

          <!-- Preview -->
          <img id="preview_foto_guru"
               src="/images/default.png"
               style="width:100px;height:100px;object-fit:cover;border-radius:50%;display:block;margin:0 auto 10px;">

          <!-- Input -->
          <input type="file" id="edit_foto_guru" name="foto" accept="image/*">
        </div>

        <div class="form-group">
          <label>NIP</label>
          <input type="text" id="edit_nip" name="nip">
        </div>

        <div class="form-group">
          <label>Nama Guru</label>
          <input type="text" id="edit_nama" name="nama">
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" id="edit_email" name="email">
        </div>

        <div class="form-group">
          <label>No HP</label>
          <input type="text" id="edit_no_hp" name="no_hp">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" onclick="closeModalGuru()" class="btn-cancel">
          Batal
        </button>

        <button type="submit" class="btn-save">
          Update
        </button>
      </div>

    </form>

  </div>

</div>

{{-- MODAL IMPORT GURU --}}
<div id="modalImportGuru" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Import Data Guru (Excel)</h2>
      <button type="button" onclick="ImportModalManager.closeModal('modalImportGuru')" class="modal-close">
        <i class='bx bx-x'></i>
      </button>
    </div>

    <div style="background: #e8f4f8; padding: 12px; border-radius: 6px; margin-bottom: 15px; border-left: 4px solid #3C91E6;">
      <div style="font-weight: 600; margin-bottom: 8px; color: #1a5a7a;">Format yang Diperlukan:</div>
      <div style="font-size: 13px; color: #333; line-height: 1.6;">
        <strong>Kolom:</strong> NIP | Nama | Email | No HP<br>
        <strong>Contoh:</strong> 198501151234567890 | Ibu Siti | siti@mail.com | 081234567890<br>
        <strong>Catatan:</strong> NIP harus 18 digit
      </div>
      <a href="{{ url('templates/template_guru.xlsx') }}" class="btn-download" style="display: inline-block; margin-top: 10px; background: #3C91E6; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 13px;">
        <i class='bx bx-download'></i> Download Template
      </a>
    </div>

    <form method="POST" action="/admin/guru/import" enctype="multipart/form-data" onsubmit="ImportModalManager.handleSubmit(this)">
      @csrf
      <div class="form-grid">
        <div class="form-group full">
          <label>File Excel (.xlsx, .xls, .csv)</label>
          <input type="file" name="file" required accept=".xlsx, .xls, .csv">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="ImportModalManager.closeModal('modalImportGuru')" class="btn-cancel">
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
