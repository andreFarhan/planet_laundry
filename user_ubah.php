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

	$id_user = $_GET['id_user'];
	$sql = "SELECT * FROM tb_user WHERE id_user = $id_user";
	$eksekusi = mysqli_query($koneksi, $sql);
	$data = mysqli_fetch_assoc($eksekusi);

	$sql_outlet = "SELECT * FROM tb_outlet ORDER BY id_outlet DESC";
	$eksekusi_outlet = mysqli_query($koneksi, $sql_outlet);

	if (isset($_POST['submit'])) {
		if (ubahUser($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Diubah','success');
			header("Location: user_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Diubah','error');
			header("Location: user_show");
			die;
		}
	}

	$role_user = ["admin","kasir","owner"];

	$id_outlet = $_SESSION['id_outlet'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ubah User</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">UBAH USER</h3>
					<input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">
					<div class="form-group">
						<label for="nama_user">NAMA LENGKAP</label>
						<input type="text" class="form-control" name="nama_user" value="<?= $data['nama_user']; ?>" required>
					</div>
					<div class="form-group">
						<label for="username">USERNAME</label>
						<input type="text" class="form-control" value="<?= $data['username']; ?>" disabled>
						<input type="hidden" name="username" value="<?= $data['username']; ?>">
					</div>
					<div class="form-group">
						<label for="password_lama">PASSWORD LAMA</label>
						<input type="password" class="form-control" name="password_lama" required>
					</div>
					<div class="form-group">
						<label for="password">PASSWORD</label>
						<input type="password" class="form-control" name="password" required>
					</div>
					<div class="form-group">
						<label for="password2">KONFIRMASI PASSWORD</label>
						<input type="password" class="form-control" name="password2" required>
					</div>
					<input type="hidden" name="id_outlet" value="<?= $id_outlet; ?>">
					<div class="form-group">
						<label for="role">TUGAS</label>
						<select class="form-control" name="role" id="role" required>
							<?php foreach ($role_user as $data_role): ?>
								<?php if ($data["role"] == $data_role): ?>
									<option value="<?= $data_role; ?>" selected><?= ucwords($data_role); ?></option>
								<?php else: ?>
									<option value="<?= $data_role; ?>"><?= ucwords($data_role); ?></option>
								<?php endif ?>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">UBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="user_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>