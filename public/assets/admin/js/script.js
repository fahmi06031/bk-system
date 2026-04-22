const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})




document.addEventListener("DOMContentLoaded", function(){

let loader = document.getElementById("top-loader");

loader.style.width = "30%";

setTimeout(function(){
loader.style.width = "70%";
},200);

window.onload = function(){
loader.style.width = "100%";

setTimeout(function(){
loader.style.opacity = "0";
},300);
}

});




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})


//siswa
function openTambahSiswa(){
document.getElementById("modalTambahSiswa").style.display="flex";
}

function closeModalSiswa(){
document.getElementById("modalTambahSiswa").style.display="none";
document.getElementById("modalEditSiswa").style.display="none";
}

function openEditSiswa(data){

    document.getElementById("modalEditSiswa").style.display = "flex";

    document.getElementById("edit_nis").value = data.nis;
    document.getElementById("edit_nama").value = data.nama;
    document.getElementById("edit_jk").value = data.jenis_kelamin;
    document.getElementById("edit_kelas").value = data.kelas_id;

    // 🔥 FIX PREVIEW FOTO
    if (data.foto && data.foto !== "") {
        document.getElementById("preview_foto").src = "/storage/" + data.foto;
    } else {
        document.getElementById("preview_foto").src = "/images/default.png";
    }

    document.getElementById("formEditSiswa").action = "/admin/siswa/" + data.id;
}

//Guru
function openTambahGuru(){
document.getElementById("modalTambahGuru").style.display="flex";
}

function closeModalGuru(){
document.getElementById("modalTambahGuru").style.display="none";
document.getElementById("modalEditGuru").style.display="none";
}

function openEditGuru(id, nip, nama, email, no_hp, foto){

    document.getElementById("modalEditGuru").style.display="flex";

    document.getElementById("edit_nip").value = nip;
    document.getElementById("edit_nama").value = nama;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_no_hp").value = no_hp;

    // ✅ SET FOTO KE PREVIEW (INI YANG KAMU BUTUHKAN)
    if (foto) {
        document.getElementById("preview_foto_guru").src = "/storage/" + foto;
    } else {
        document.getElementById("preview_foto_guru").src = "/images/default.png";
    }

    document.getElementById("formEditGuru").action = "/admin/guru/" + id;
}

//pelanggaran
function openTambahPelanggaran(){
document.getElementById("modalTambahPelanggaran").style.display="flex";
}

function closeModalPelanggaran(){
document.getElementById("modalTambahPelanggaran").style.display="none";
}

// kelas
function openTambahKelas(){
document.getElementById("modalTambahKelas").style.display="flex";
}

function closeModalKelas(){
document.getElementById("modalTambahKelas").style.display="none";
document.getElementById("modalEditKelas").style.display="none";
}


function openEditKelas(id,nama,tingkat,jurusan,tahun){

document.getElementById("modalEditKelas").style.display="flex";

document.getElementById("edit_nama_kelas").value = nama;
document.getElementById("edit_tingkat").value = tingkat;
document.getElementById("edit_jurusan").value = jurusan;
document.getElementById("edit_tahun_ajaran").value = tahun;

document.getElementById("formEditKelas").action = "/admin/kelas/"+id;

}

//mapel
function openTambahMapel(){
document.getElementById("modalTambahMapel").style.display="flex";
}

function closeModalMapel(){
document.getElementById("modalTambahMapel").style.display="none";
document.getElementById("modalEditMapel").style.display="none";
}

function openEditMapel(id,kode,nama,guru){

document.getElementById("modalEditMapel").style.display="flex";

document.getElementById("edit_kode").value = kode;
document.getElementById("edit_nama").value = nama;
document.getElementById("edit_guru").value = guru;

document.getElementById("formEditMapel").action = "/admin/mata-pelajaran/"+id;

}

function openViewGuru(foto,nip,nama,email,no_hp){

document.getElementById('view_foto').src = foto;
document.getElementById('view_nip').value = nip;
document.getElementById('view_nama').value = nama;
document.getElementById('view_email').value = email;
document.getElementById('view_no_hp').value = no_hp;

document.getElementById('modalViewGuru').style.display = 'block';

}
