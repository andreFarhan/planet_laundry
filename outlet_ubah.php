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
	$sql = "SELECT * FROM tb_outlet WHERE id_outlet = $id_outlet";
	$eksekusi = mysqli_query($koneksi, $sql);
	$data = mysqli_fetch_assoc($eksekusi);

	if (isset($_POST['submit'])) {
		if (ubahOutlet($_POST) > 0 ) {
			setAlert('Berhasil!','Data Berhasil Diubah','success');
			header("Location: outlet_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Diubah','error');
			header("Location: outlet_show");
			die;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ubah Outlet</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">UBAH OUTLET</h3>
					<input type="hidden" name="id_outlet" value="<?= $data['id_outlet']; ?>">
					<div class="form-group">
						<label for="nama_outlet">NAMA OUTLET</label>
						<input type="text" class="form-control" name="nama_outlet" value="<?= $data['nama_outlet']; ?>" required>
					</div>
					<div class="form-group">
						<label for="alamat_outlet">ALAMAT OUTLET</label>
						<input type="text" class="form-control" name="alamat_outlet" value="<?= $data['alamat_outlet']; ?>" required>
					</div>
					<div class="form-group">
						<label for="telp_outlet">TELP OUTLET</label>
						<input type="number" class="form-control" name="telp_outlet" value="<?= $data['telp_outlet']; ?>" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">UBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="outlet_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>