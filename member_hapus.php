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

	$id_member = $_GET['id_member'];

	if (hapusMember($id_member) > 0) {
		setAlert('Berhasil!','Data Berhasil Dihapus','success');
		header("Location: member_show");
		die;
	}
	else{
		setAlert('Gagal!','Data Gagal Dihapus','error');
		header("Location: member_show");
		die;
	}
?>