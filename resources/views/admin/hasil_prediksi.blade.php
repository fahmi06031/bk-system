@extends('layouts.admin')

@section('content')

<div class="head-title">
  <div class="left">
    <h1>Hasil Prediksi Risiko Siswa</h1>
  </div>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div style="background:#4CAF50;color:white;padding:10px 15px;border-radius:8px;margin-bottom:15px;">
  {{ session('success') }}
</div>
@endif

<div class="table-data">
  <div class="order">

    <table>

      <thead>
        <tr>
          <th>NIS</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Tgl Prediksi</th>
          <th>Tingkat Risiko</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>

        {{-- CEK DATA --}}
        @forelse($prediksi as $p)

        <tr>

          <td>{{ $p->nis }}</td>

          <td>{{ $p->nama_siswa }}</td>

          <td>{{ $p->kelas }}</td>

          <td>
            {{ \Carbon\Carbon::parse($p->tgl_prediksi)->format('d-m-Y') }}
          </td>

          <td>
            @if($p->tingkat_risiko == 'Tinggi')
              <span style="background:red;color:white;padding:5px 10px;border-radius:6px;">
                Tinggi
              </span>

            @elseif($p->tingkat_risiko == 'Sedang')
              <span style="background:orange;color:white;padding:5px 10px;border-radius:6px;">
                Sedang
              </span>

            @else
              <span style="background:green;color:white;padding:5px 10px;border-radius:6px;">
                Rendah
              </span>
            @endif
          </td>

          <td>
            <form action="/admin/hasil-prediksi/{{ $p->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
              @csrf
              @method('DELETE')

              <button style="background:red;color:white;border:none;padding:5px 10px;border-radius:6px;">
                Hapus
              </button>
            </form>
          </td>

        </tr>

        @empty

        {{-- JIKA DATA KOSONG --}}
        <tr>
          <td colspan="6" style="text-align:center;padding:20px;">
            Tidak ada data prediksi
          </td>
        </tr>

        @endforelse

      </tbody>

    </table>

  </div>
</div>

@endsection
