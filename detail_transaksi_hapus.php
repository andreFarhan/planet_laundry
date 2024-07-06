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

	$id_detail_transaksi = $_GET['id_detail_transaksi'];

	if (isset($id_detail_transaksi)) {
		if (hapusDetailTransaksi($id_detail_transaksi) > 0) {
			setAlert('Berhasil!','Data Berhasil Dihapus','success');
			header("Location: transaksi_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Dihapus','error');
		}
	}
 ?>