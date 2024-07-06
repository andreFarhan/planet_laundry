<?php 
	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form");
	}

	//kunci akses halaman
	if ($_SESSION['role'] !== 'admin') {
		header("Location: laundry_show");
	}

	$id_paket = $_GET['id_paket'];

	if (hapusPaket($id_paket) > 0) {
		setAlert('Berhasil!','Data Berhasil Dihapus','success');
		header("Location: paket_show");
		die;
	}
	else{
		setAlert('Gagal!','Data Gagal Dihapus','error');
		header("Location: paket_show");
		die;
	}
 ?>