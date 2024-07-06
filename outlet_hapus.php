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

	$id_outlet = $_GET['id_outlet'];

	if (hapusOutlet($id_outlet) > 0) {
		echo "
		<script>
		alert('Data Berhasil Dihapus')
		document.location.href='outlet_show'
		</script>
		";
	}
	else{
		echo "
		<script>
		alert('Data Gagal Dihapus')
		document.location.href='outlet_show'
		</script>
		";
	}
 ?>