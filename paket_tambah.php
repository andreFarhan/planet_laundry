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
		if (tambahPaket($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Ditambahkan','success');
			header("Location: paket_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Ditambahkan','error');
			header("Location: paket_show");
			die;
		}
	}

	$sql = "SELECT * FROM tb_outlet ORDER BY id_outlet DESC";
	$eksekusi = mysqli_query($koneksi, $sql);

	$id_outlet = $_SESSION['id_outlet'];
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah Paket</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">TAMBAH PAKET</h3>
					<input type="hidden" name="id_outlet" value="<?= $id_outlet; ?>">
					<div class="form-group">
						<label for="jenis">JENIS PAKET</label>
						<select name="jenis" id="jenis" class="form-control">
							<option>-- Pilih Paket --</option>
							<option value="kiloan">KILOAN</option>
							<option value="selimut">SELIMUT</option>
							<option value="bed cover">BED COVER</option>
							<option value="kaos">KAOS</option>
							<option value="lain">LAIN-LAIN</option>
						</select>
					</div>				
					<div class="form-group">
						<label for="nama_paket">NAMA PAKET</label>
						<input type="text" class="form-control" name="nama_paket" required>
					</div>
					<div class="form-group">
						<label for="harga">HARGA</label>
						<input type="number" class="form-control" name="harga" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">TAMBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="paket_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>