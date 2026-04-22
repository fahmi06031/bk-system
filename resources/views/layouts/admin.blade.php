<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

	<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

	<title>Admin Dashboard</title>
</head>


<body>
<div id="top-loader"></div>

@include('components.sidebar_admin')

<section id="content">

@include('components.navbar')

<main>
@yield('content')
</main>

</section>

<script src="{{ asset('assets/admin/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: "{{ session('success') }}",
    confirmButtonColor: '#3085d6',
    showClass: {
        popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
    }
});
</script>
@endif
</body>
</html>

<script>

function confirmDelete(button){

let form = button.closest("form");

Swal.fire({
title: 'Yakin ingin menghapus?',
text: "Data tidak bisa dikembalikan!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
cancelButtonColor: '#3085d6',
confirmButtonText: 'Ya, hapus',
cancelButtonText: 'Batal'
}).then((result) => {

if (result.isConfirmed) {
form.submit();
}

});

}

</script>
