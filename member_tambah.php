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

	if (isset($_POST['submit'])) {
		if (tambahMember($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Ditambahkan','success');
			header("Location: member_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Ditambahkan','error');
			header("Location: member_show");
			die;
		}
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah Member</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">TAMBAH MEMBER</h3>
					<div class="form-group">
						<label for="nama_member">NAMA LENGKAP</label>
						<input type="text" class="form-control" name="nama_member" required>
					</div>
					<div class="form-group">
						<label for="alamat_member">ALAMAT</label>
						<input type="text" class="form-control" name="alamat_member" required>
					</div>
					<div class="form-group">
						<label class="form-check-label" for="jenis_kelamin">JENIS KELAMIN</label>
						<div class="form-check">
							<input type="radio" id="L" name="jenis_kelamin" value="L" class="form-check-input" required>
							<label class="form-check-label" for="L">LAKI-LAKI</label>
						</div>
						<div class="form-check">
							<input type="radio" id="P" name="jenis_kelamin" value="P" class="form-check-input">
							<label class="form-check-label" for="P">PEREMPUAN</label>
						</div>
					</div>
					<div class="form-group">
						<label for="telp_member">TELEPON</label>
						<input type="number" class="form-control" name="telp_member" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">TAMBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="member_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>