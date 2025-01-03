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

	$id_paket = $_GET['id_paket'];
	$sql = "SELECT * FROM tb_paket WHERE id_paket = $id_paket";
	$eksekusi = mysqli_query($koneksi, $sql);
	$data = mysqli_fetch_assoc($eksekusi);

	$sql_outlet = "SELECT * FROM tb_outlet ORDER BY id_outlet DESC";
	$eksekusi_outlet = mysqli_query($koneksi, $sql_outlet);

	$id_outlet = $_SESSION['id_outlet'];

	if (isset($_POST['submit'])) {
		if (ubahPaket($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Diubah','success');
			header("Location: paket_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Diubah','error');
			header("Location: paket_show");
			die;
		}
	}

	$jenis_paket = ["kiloan","selimut","bed cover","kaos","lain"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ubah Paket</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">UBAH PAKET</h3>
					<input type="hidden" name="id_paket" value="<?= $data['id_paket']; ?>">
					<input type="hidden" name="id_outlet" value="<?= $id_outlet; ?>">
					<div class="form-group">
						<label for="jenis">JENIS PAKET</label>
						<select name="jenis" id="jenis" class="form-control">
							<?php foreach ($jenis_paket as $data_jenis): ?>
								<?php if ($data["jenis"] == $data_jenis): ?>
									<option value="<?= $data_jenis ?>" selected><?= $data_jenis ?></option>
								<?php else: ?>
									<option value="<?= $data_jenis ?>"><?= $data_jenis ?></option>
								<?php endif ?>
							<?php endforeach ?>
						</select>
					</div>				
					<div class="form-group">
						<label for="nama_paket">NAMA PAKET</label>
						<input type="text" class="form-control" name="nama_paket" value="<?= $data['nama_paket']; ?>" required>
					</div>
					<div class="form-group">
						<label for="harga">HARGA</label>
						<input type="number" class="form-control" name="harga" value="<?= $data['harga']; ?>" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">UBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="paket_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>