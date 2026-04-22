@extends('layouts.admin')

@section('content')

<div class="head-title">
  <div class="left">
    <h1>Dashboard</h1>

    <ul class="breadcrumb">
      <li><a href="#">Dashboard</a></li>
      <li><i class='bx bx-chevron-right'></i></li>
      <li><a class="active">Home</a></li>
    </ul>
  </div>
</div>


{{-- INFO BOX --}}
<ul class="box-info">

<li>
<i class='bx bxs-group'></i>
<span class="text">
<h3>{{ $totalSiswa }}</h3>
<p>Total Siswa</p>
</span>
</li>

<li>
<i class='bx bxs-analyse'></i>
<span class="text">
<h3>{{ $totalPrediksi }}</h3>
<p>Total Prediksi</p>
</span>
</li>

<li>
<i class='bx bxs-error'></i>
<span class="text">
<h3>{{ $risikoTinggi }}</h3>
<p>Risiko Tinggi</p>
</span>
</li>

</ul>


{{-- DATA TERBARU --}}
<div class="table-data">

<div class="order">

<div class="head">
<h3>Data Prediksi Terbaru</h3>
</div>

<table>

<thead>
<tr>
<th>Nama</th>
<th>Kelas</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@forelse($siswaTerbaru as $s)

<tr>
<td>
<p>{{ $s->nama_siswa }}</p>
</td>

<td>{{ $s->kelas }}</td>

<td>

@php $status = $s->tingkat_risiko; @endphp

@if($status == 'Tinggi')
<span style="background:red;color:white;padding:5px 10px;border-radius:6px;">
Tinggi
</span>

@elseif($status == 'Sedang')
<span style="background:orange;color:white;padding:5px 10px;border-radius:6px;">
Sedang
</span>

@else
<span style="background:green;color:white;padding:5px 10px;border-radius:6px;">
Rendah
</span>
@endif

</td>

</tr>

@empty

<tr>
<td colspan="3" style="text-align:center;">
Tidak ada data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection
