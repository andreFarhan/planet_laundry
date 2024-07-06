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

	if (!isset($id_transaksi)) {
		header("Location: transaksi_show");
	}

	if (isset($_POST['submit'])) {
		if (tambahDetailTransaksi($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Ditambahkan','success');
			header("Location: detail_transaksi_show.php?id_transaksi=$id_transaksi");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Ditambahkan','error');
			header("Location: transaksi_show");
			die;
		}
	}


	$sql_transaksi = "SELECT * FROM tb_transaksi
	WHERE id_transaksi = '$id_transaksi' ORDER BY id_transaksi DESC";
	$eksekusi_transaksi = mysqli_query($koneksi, $sql_transaksi);

	$sql_member = "SELECT * FROM tb_transaksi 
	INNER JOIN tb_member ON tb_member.id_member = tb_transaksi.id_member
	WHERE id_transaksi = '$id_transaksi' ORDER BY id_transaksi DESC";
	$eksekusi_member = mysqli_query($koneksi, $sql_member);

	$sql_paket = "SELECT * FROM tb_paket ORDER BY id_paket DESC";
	$eksekusi_paket = mysqli_query($koneksi, $sql_paket);

	$count_paket = mysqli_num_rows($eksekusi_paket);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tambah Detail Transaksi</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">TAMBAH DETAIL TRANSAKSI</h3>
					<div class="form-group">
						<label>MEMBER</label>
						<input class="form-control" type="text" value="<?= mysqli_fetch_array($eksekusi_member)['nama_member']; ?>" disabled>
					</div>
					<input type="hidden" value="<?= $id_transaksi; ?>" name="id_transaksi">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<label for="id_paket">PAKET</label>
							<select name="id_paket" id="id_paket" class="form-control">
							<?php while ($data_paket = mysqli_fetch_array($eksekusi_paket)) : ?>
								<option value="<?= $data_paket['id_paket']; ?>"><?= $data_paket['nama_paket']; ?> | <?= $data_paket['harga']; ?></option>
							<?php endwhile ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="qty" class="float-right">JUMLAH</label>
							<input type="number" name="qty" class="form-control">
						</div>
					</div>
				</div>
					<div class="form-group">
						<label for="keterangan">KETERANGAN</label>
						<textarea name="keterangan" id="keterangan" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">TAMBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="transaksi_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>