<?php 
	
	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form");
	}

	//kunci akses halaman
	if ($_SESSION['role'] !== 'admin' AND $_SESSION['role'] !== 'kasir') {
		header("Location: laundry_show");
	}

	$id_transaksi = $_GET['id_transaksi'];

	$sql = "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'";
	$eksekusi = mysqli_query($koneksi, $sql);
	$data = mysqli_fetch_assoc($eksekusi);
	if ($data['status'] == 'baru') {
		$status = 'proses';
	}elseif ($data['status'] == 'proses'){
		$status = 'selesai';
	}else{
		$status = 'diambil';
	}
	$sql_status = "UPDATE tb_transaksi SET status = '$status' WHERE id_transaksi = '$id_transaksi'";
	$eksekusi_status = mysqli_query($koneksi, $sql_status);

	if ($eksekusi_status) {
		setAlert('Berhasil!','Data Berhasil Diubah','success');
		header("Location: transaksi_show");
		die;
	}
	else{
		setAlert('Gagal!','Data Gagal Diubah','error');
		header("Location: transaksi_show");
		die;
	}

 ?>