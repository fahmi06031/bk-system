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

{{-- TEMPAT UNTUK MODALS (AGAR TAMPIL DI ATAS SEMUA) --}}
@yield('modals')

<script src="{{ asset('assets/admin/js/script.js') }}"></script>
<script src="{{ asset('assets/admin/js/import-modal.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    confirmButtonText: 'Lanjutkan',
    confirmButtonColor: '#3C91E6',
    customClass: {
        popup: 'custom-swal-popup',
        title: 'custom-swal-title',
        htmlContainer: 'custom-swal-text',
        confirmButton: 'custom-swal-confirm'
    },
    showClass: {
        popup: 'animate__animated animate__zoomIn animate__faster'
    },
    hideClass: {
        popup: 'animate__animated animate__zoomOut animate__faster'
    }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    confirmButtonText: 'Tutup',
    confirmButtonColor: '#DB504A',
    customClass: {
        popup: 'custom-swal-popup animate__animated animate__shakeX animate__faster',
        title: 'custom-swal-title',
        htmlContainer: 'custom-swal-text',
        confirmButton: 'custom-swal-confirm'
    }
});
</script>
@endif

@if($errors->any())
<script>
let errorMessage = '';
@foreach($errors->all() as $error)
    errorMessage += '• {{ $error }}\n';
@endforeach

Swal.fire({
    icon: 'error',
    title: 'Validasi Error',
    text: errorMessage,
    confirmButtonText: 'Tutup',
    confirmButtonColor: '#DB504A',
    customClass: {
        popup: 'custom-swal-popup animate__animated animate__shakeX animate__faster',
        title: 'custom-swal-title',
        htmlContainer: 'custom-swal-text',
        confirmButton: 'custom-swal-confirm'
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
text: "Data yang dihapus tidak bisa dikembalikan!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#DB504A',
cancelButtonColor: '#AAAAAA',
confirmButtonText: 'Ya, hapus!',
cancelButtonText: 'Batal',
customClass: {
    popup: 'custom-swal-popup',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    confirmButton: 'custom-swal-confirm',
    cancelButton: 'custom-swal-cancel'
},
showClass: {
    popup: 'animate__animated animate__zoomIn animate__faster'
},
hideClass: {
    popup: 'animate__animated animate__zoomOut animate__faster'
}
}).then((result) => {

if (result.isConfirmed) {
form.submit();
}

});

}

// GLOBAL CONFIRMATION FOR SAVE (ADD/EDIT)
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const isDelete = form.querySelector('input[name="_method"][value="DELETE"]');
        const action = form.getAttribute('action') || '';
        const isImport = action.includes('import');
        const isProses = action.includes('proses'); // Form proses tidak perlu konfirmasi ganda
        const hasNoConfirm = form.classList.contains('no-confirm');
        
        if (!isDelete && !isImport && !isProses && !hasNoConfirm) {
            form.addEventListener('submit', function(e) {
                // Biarkan submit jika sudah dikonfirmasi
                if (form.dataset.confirmed === 'true') {
                    return; 
                }

                e.preventDefault();
                
                Swal.fire({
                    title: 'Simpan Data?',
                    text: "Pastikan data yang Anda masukkan sudah benar!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3C91E6',
                    cancelButtonColor: '#AAAAAA',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        htmlContainer: 'custom-swal-text',
                        confirmButton: 'custom-swal-confirm',
                        cancelButton: 'custom-swal-cancel'
                    },
                    showClass: {
                        popup: 'animate__animated animate__zoomIn animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOut animate__faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            });
        }
    });
});

</script>
