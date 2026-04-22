@extends('layouts.admin')

@section('content')

<div class="head-title">

  <div class="left">
    <h1>Data Siswa</h1>
  </div>

  <button class="btn-download" onclick="openTambahSiswa()">
    <i class='bx bx-plus'></i>
    <span class="text">Tambah Siswa</span>
  </button>

</div>


<div class="table-data">
  <div class="order">

    <table>

      <thead>
        <tr>
          <th>Foto</th>
          <th>NIS</th>
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Kelas</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>

        @foreach($siswa as $s)

        <tr>

          <td>
            @if($s->foto)
            <img src="{{ asset('storage/'.$s->foto) }}" width="40">
            @endif
          </td>

          <td>{{$s->nis}}</td>
          <td>{{$s->nama}}</td>
          <td>{{$s->jenis_kelamin}}</td>
          <td>{{$s->kelas->nama_kelas ?? '-'}}</td>

          <td style="display:flex;gap:10px;">


<button onclick='openEditSiswa({
    id: "{{$s->id}}",
    nis: "{{$s->nis}}",
    nama: "{{$s->nama}}",
    jenis_kelamin: "{{$s->jenis_kelamin}}",
    kelas_id: "{{$s->kelas_id}}",
    foto: "{{$s->foto}}"
})'
style="background:#3C91E6;color:white;border:none;padding:5px 10px;border-radius:6px;">
Edit
</button>


            <form action="/admin/siswa/{{$s->id}}" method="POST">

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

@if ($errors->any())
<div style="background:#ffdddd;padding:10px;margin-bottom:10px;border-radius:6px;">
    <ul style="margin:0;padding-left:20px;color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
{{-- MODAL TAMBAH SISWA --}}

<div id="modalTambahSiswa" class="modal">

  <div class="modal-content">

    <div class="modal-header">

      <h2>Tambah Data Siswa</h2>

      <button onclick="closeModalSiswa()" class="modal-close">
        <i class='bx bx-x'></i>
      </button>

    </div>


    <form method="POST" action="/admin/siswa" enctype="multipart/form-data">

      @csrf

      <div class="form-grid">

        <div class="form-group">
          <label>NIS</label>
          <input type="text" name="nis" placeholder="Masukkan NIS">
        </div>

        <div class="form-group">
          <label>Nama Siswa</label>
          <input type="text" name="nama" placeholder="Masukkan Nama Siswa">
        </div>

        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kelas</label>

          <select name="kelas_id">

            @foreach($kelas as $k)

            <option value="{{$k->id}}">
              {{$k->nama_kelas}}
            </option>

            @endforeach

          </select>

        </div>

        <div class="form-group">
          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir">
        </div>

        <div class="form-group">
          <label>Foto</label>
          <input type="file" name="foto">
        </div>

        <div class="form-group full">
          <label>Alamat</label>
          <textarea name="alamat" rows="3"></textarea>
        </div>

      </div>


      <div class="modal-footer">

        <button type="button" onclick="closeModalSiswa()" class="btn-cancel">
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


{{-- MODAL EDIT SISWA --}}

<div id="modalEditSiswa" class="modal">

  <div class="modal-content">

    <div class="modal-header">
      <h2>Edit Data Siswa</h2>
      <button onclick="closeModalSiswa()" class="modal-close">
        <i class='bx bx-x'></i>
      </button>
    </div>

    <!-- TAMBAH enctype -->
    <form id="formEditSiswa" method="POST" enctype="multipart/form-data">

      @csrf
      @method('PUT')

      <div class="form-grid">

        <!-- FOTO -->
        <div class="form-group" style="grid-column: span 2; text-align:center;">
          <label>Foto Siswa</label><br>

          <div style="display:flex; justify-content:center; margin-block-end: 30px;">
           <img id="preview_foto" src="" style="width:100px;height:100px;object-fit:cover;border-radius:50%;">
          </div>

          <!-- Input File -->
          <input type="file" id="edit_foto" name="foto" accept="image/*">
        </div>

        <div class="form-group">
          <label>NIS</label>
          <input type="text" id="edit_nis" name="nis">
        </div>

        <div class="form-group">
          <label>Nama</label>
          <input type="text" id="edit_nama" name="nama">
        </div>

        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select id="edit_jk" name="jenis_kelamin">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kelas</label>
          <select id="edit_kelas" name="kelas_id">
            @foreach($kelas as $k)
            <option value="{{$k->id}}">
              {{$k->nama_kelas}}
            </option>
            @endforeach
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" onclick="closeModalSiswa()" class="btn-cancel">
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
<script>
  function openModalEditSiswa(data) {

      document.getElementById('edit_nis').value = data.nis;
      document.getElementById('edit_nama').value = data.nama;
      document.getElementById('edit_jk').value = data.jenis_kelamin;
      document.getElementById('edit_kelas').value = data.kelas_id;

      // tampilkan foto lama (kalau ada)
      if (data.foto) {
          document.getElementById('preview_foto').src = '/storage/' + data.foto;
      } else {
          document.getElementById('preview_foto').src = '/images/default.png';
      }

      // set action form
      document.getElementById('formEditSiswa').action = '/siswa/' + data.id;

      document.getElementById('modalEditSiswa').style.display = 'block';
  }
</script>
