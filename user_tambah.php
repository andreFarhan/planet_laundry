<?php 

	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form");
	}

	//kunci akses halaman
	if ($_SESSION['role'] == 'owner') {
		header("Location: laundry_show");
	}

	if (isset($_POST['submit'])) {
		if (tambahUser($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Ditambahkan','success');
			header("Location: user_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Ditambahkan','error');
			header("Location: user_show");
			die;
		}
	}

	$id_outlet = $_SESSION['id_outlet'];

	$outlet = mysqli_query($koneksi, "SELECT * FROM tb_outlet ORDER BY id_outlet DESC");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah User</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">TAMBAH USER</h3>
					<div class="form-group">
						<label for="nama_user">NAMA LENGKAP</label>
						<input type="text" class="form-control" name="nama_user" required>
					</div>
					<div class="form-group">
						<label for="username">USERNAME</label>
						<input type="text" class="form-control" name="username" required>
					</div>
					<div class="form-group">
						<label for="password">PASSWORD</label>
						<input type="password" class="form-control" name="password" required>
					</div>
					<div class="form-group">
						<label for="password2">KONFIRMASI PASSWORD</label>
						<input type="password" class="form-control" name="password2" required>
					</div>
					<?php if ($id_outlet == 0): ?>
						<div class="form-group">
							<label for="id_outlet">OUTLET</label>
							<select class="form-control" name="id_outlet" id="id_outlet">
								<option>-- Pilih Outlet --</option>
								<?php foreach ($outlet as $data_outlet): ?>
									<option value="<?= $data_outlet['id_outlet']; ?>"><?= $data_outlet['nama_outlet']; ?></option>
								<?php endforeach ?>
							</select>
						</div>
					<?php else: ?>
						<input type="hidden" name="id_outlet" value="<?= $id_outlet; ?>">
					<?php endif ?>
					<div class="form-group">
						<label for="role">TUGAS</label>
						<select class="form-control" name="role" id="role" required>
							<option>-- Pilih Tugas --</option>
							<option value="admin">Admin</option>
							<option value="kasir">Kasir</option>
							<option value="owner">Owner</option>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">TAMBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="user_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>