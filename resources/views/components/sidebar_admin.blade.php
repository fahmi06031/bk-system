<section id="sidebar">

<a href="#" class="brand">
<i class='bx bxs-smile'></i>
<span class="text">BK System</span>
</a>


<ul class="side-menu top">



</ul>
<ul class="side-menu">
<li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
<a href="{{ url('/admin/dashboard') }}">
<i class='bx bxs-dashboard'></i>
<span class="text">Dashboard</span>
</a>
</li>


<li class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
<a href="{{ url('/admin/siswa') }}">
<i class='bx bxs-group'></i>
<span class="text">Data Siswa</span>
</a>
</li>

<li class="{{ request()->is('admin/guru*') ? 'active' : '' }}">
<a href="{{ url('/admin/guru') }}">
<i class='bx bxs-user'></i>
<span class="text">Data Guru</span>
</a>
</li>

<li class="{{ request()->is('admin/kelas*') ? 'active' : '' }}">
<a href="{{ url('/admin/kelas') }}">
<i class='bx bxs-school'></i>
<span class="text">Data Kelas</span>
</a>
</li>

<li class="{{ request()->is('admin/mata-pelajaran*') ? 'active' : '' }}">
<a href="{{ url('/admin/mata-pelajaran') }}">
<i class='bx bxs-book'></i>
<span class="text">Mata Pelajaran</span>
</a>
</li>

<li class="{{ request()->is('admin/prediksi-risiko*') ? 'active' : '' }}">
<a href="{{ url('/admin/prediksi-risiko') }}">
<i class='bx bxs-chart'></i>
<span class="text">Prediksi Risiko</span>
</a>
</li>

<li class="{{ request()->is('admin/hasil-prediksi*') ? 'active' : '' }}">
<a href="{{ url('/admin/hasil-prediksi') }}">
    <i class='bx bxs-chart'></i>
<span class="text">Hasil Prediksi</span>
</a>
</li>


</ul>



<ul class="side-menu">


<li>
<a href="/logout" class="logout">
<i class='bx bxs-log-out-circle'></i>
<span class="text">Logout</span>
</a>
</li>

</ul>

</section>
