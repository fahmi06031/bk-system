@extends('layouts.admin')

@section('content')

{{-- SELECT2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.btn-download {
  background: linear-gradient(135deg, #28a745, #20c997);
  color: white;
  border: none;
  padding: 12px 20px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: bold;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;
margin-top: 15px;
}

/* hover */
.btn-download:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* klik */
.btn-download:active {
  transform: scale(0.95);
}
</style>
<div class="head-title">
  <div class="left">
    <h1>Prediksi Risiko Siswa</h1>
  </div>
</div>

<div class="table-data">
  <div class="order">

    <form action="/admin/prediksi-risiko/proses" method="POST">
      @csrf

      <div class="form-grid">

        {{-- PILIH SISWA (SEARCHABLE) --}}
        <div class="form-group full">
          <label>Nama Siswa</label>

          <select name="siswa_id" id="siswa_select" style="width:100%">

            @foreach($siswa as $s)
            <option
              value="{{$s->id}}"
              data-nis="{{$s->nis}}"
              data-nama="{{$s->nama}}"
            >
              {{$s->nis}} - {{$s->nama}}
            </option>
            @endforeach

          </select>
        </div>

        {{-- AUTO NIS --}}
        <div class="form-group">
          <label>NIS</label>
          <input type="text" id="nis" readonly>
        </div>

        {{-- AUTO NAMA --}}
        <div class="form-group">
          <label>Nama Siswa</label>
          <input type="text" id="nama" readonly>
        </div>

        {{-- KEHADIRAN --}}
        <div class="form-group">
          <label>Kehadiran (%)</label>
          <input type="number" name="kehadiran">
        </div>

        {{-- NILAI --}}
        <div class="form-group">
          <label>Nilai Akademik</label>
          <input type="number" name="nilai">
        </div>

        {{-- SIKAP --}}
        <div class="form-group">
          <label>Sikap</label>

          <select name="sikap">
            <option value="Baik">Baik</option>
            <option value="Cukup">Cukup</option>
            <option value="Buruk">Buruk</option>
          </select>

        </div>

      </div>

      <div style="margin-top:20px">
        <button class="btn-save">
          <i class='bx bx-analyse'></i>
          Proses Prediksi Risiko
        </button>
      </div>

    </form>

  </div>
</div>


{{-- HASIL PREDIKSI --}}
{{-- HASIL PREDIKSI --}}
@if(session('hasil_prediksi'))

@php
    $warna = '#6c757d'; // default abu

    if(session('hasil_prediksi') == 'Aman'){
        $warna = 'green';
    } elseif(session('hasil_prediksi') == 'Waspada'){
        $warna = 'orange';
    } elseif(session('hasil_prediksi') == 'Berisiko'){
        $warna = 'red';
    }
@endphp

<div class="table-data">
  <div class="order">

    <h3>Hasil Prediksi</h3>

    <div style="margin-top:15px">

      <span style="
        background:{{ $warna }};
        color:white;
        padding:10px 20px;
        border-radius:20px;
        font-size:16px;
        font-weight:bold;
        display:inline-block;
      ">
        {{ session('hasil_prediksi') }}
      </span>

    </div>

    {{-- FORM SIMPAN --}}
    <form action="/admin/prediksi-risiko/simpan" method="POST">
      @csrf

      <input type="hidden" name="nis" value="{{ session('nis') }}">
      <input type="hidden" name="nama_siswa" value="{{ session('nama_siswa') }}">
      <input type="hidden" name="kelas" value="{{ session('kelas') }}">
      <input type="hidden" name="tingkat_risiko" value="{{ session('hasil_prediksi') }}">

      <button class="btn-download">
        Simpan Hasil
      </button>
    </form>

  </div>
</div>

@endif


{{-- JQUERY + SELECT2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- SCRIPT --}}
<script>
$(document).ready(function() {

    // aktifkan search dropdown
    $('#siswa_select').select2({
        placeholder: "Cari NIS atau Nama Siswa",
        allowClear: true,
        width: '100%'
    });

    // auto fill saat pilih siswa
    $('#siswa_select').on('change', function() {
        let selected = this.options[this.selectedIndex];

        let nis = selected.getAttribute('data-nis');
        let nama = selected.getAttribute('data-nama');

        $('#nis').val(nis);
        $('#nama').val(nama);
    });

    // auto isi saat pertama load
    let selected = $('#siswa_select option:selected');

    $('#nis').val(selected.data('nis'));
    $('#nama').val(selected.data('nama'));

});
</script>

@endsection
