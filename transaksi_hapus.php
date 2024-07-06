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

	$id_transaksi = $_GET['id_transaksi'];

	if (hapusTransaksi($id_transaksi) > 0) {
		setAlert('Berhasil!','Data Berhasil Dihapus','success');
		header("Location: transaksi_show");
		die;
	}else{
		setAlert('Gagal!','Data Gagal Dihapus','error');
		header("Location: transaksi_show");
		die;
	}
 ?>
