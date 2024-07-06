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

	if (isset($id_transaksi)) {
		$id_transaksi = $_GET['id_transaksi'];
	}
	else{
		header("Location: index");
	}

	$tanggal_bayar = date('Y-m-d\TH:i:s');
	$sql_bayar = "UPDATE tb_transaksi SET dibayar = 'dibayar', tanggal_bayar = '$tanggal_bayar' WHERE id_transaksi = '$id_transaksi'";
	$eksekusi_bayar = mysqli_query($koneksi, $sql_bayar);

	if ($eksekusi_bayar) {
		echo "
		<script>
		alert('Transaksi Berhasil Dibayar!')
		document.location.href='transaksi_show'
		</script>
		";
	}
	else{
		echo "
		<script>
		alert('Transaksi Gagal Dibayar!')
		</script>
		";	
	}


 ?>