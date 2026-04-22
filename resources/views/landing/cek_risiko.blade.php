<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cek Risiko Siswa</title>

<style>
*{box-sizing:border-box;font-family:Segoe UI}
body{margin:0;background:linear-gradient(135deg,#ffffff,#01c8ff)}

.container{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

.card{
background:white;
width:100%;
max-width:420px;
padding:25px;
border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
text-align:center;
}

input{
width:100%;
padding:14px;
margin-top:15px;
border-radius:10px;
border:1px solid #ddd;
}

button{
width:100%;
padding:14px;
margin-top:15px;
border:none;
border-radius:10px;
background:#007bff;
color:white;
font-weight:bold;
}

.badge{
margin-top:10px;
padding:10px 20px;
border-radius:20px;
color:white;
font-weight:bold;
display:inline-block;
}
</style>
</head>

<body>

<div class="container">
<div class="card">

<h2>🔍 Cek Risiko Siswa</h2>
<p style="color:#666;font-size:14px;">Masukkan NIS atau Nama</p>

<form method="POST" action="/">
@csrf

<input type="text" name="keyword" placeholder="Contoh: 22222 / Akmal" required>

<button>Cari Sekarang</button>

</form>

@if(isset($hasil))

<div style="margin-top:20px">

<h3>{{ $hasil->nama_siswa }}</h3>
<p>{{ $hasil->nis }}</p>

@php
$warna='gray';
if($hasil->tingkat_risiko=='Tinggi')$warna='red';
elseif($hasil->tingkat_risiko=='Sedang')$warna='orange';
else $warna='green';
@endphp

<div class="badge" style="background:{{ $warna }}">
{{ $hasil->tingkat_risiko }}
</div>

</div>

@endif

{{-- LOGIN ADMIN --}}
<a href="/login" style="
display:block;
margin-top:20px;
color:#007bff;
text-decoration:none;
font-weight:bold;
">
Login Admin
</a>

</div>
</div>

</body>
</html>
