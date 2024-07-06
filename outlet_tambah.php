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

	if (isset($_POST['submit'])) {
		if (tambahOutlet($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Ditambahkan','success');
			header("Location: outlet_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Ditambahkan','error');
			header("Location: outlet_show");
			die;
		}
	}

	$sql = "SELECT * FROM tb_outlet ORDER BY id_outlet DESC";
	$eksekusi = mysqli_query($koneksi, $sql);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah Outlet</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">TAMBAH OUTLET</h3>
					<div class="form-group">
						<label for="nama_outlet">NAMA</label>
						<input type="text" class="form-control" name="nama_outlet" required>
					</div>
					<div class="form-group">
						<label for="alamat_outlet">ALAMAT</label>
						<input type="text" class="form-control" name="alamat_outlet" required>
					</div>
					<div class="form-group">
						<label for="telp_outlet">TELEPON</label>
						<input type="number" class="form-control" name="telp_outlet" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">TAMBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="outlet_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>