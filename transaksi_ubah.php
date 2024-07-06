<?php 

	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form");
	}

	//kunci akses halaman
	if ($_SESSION['role'] !== 'admin' AND $_SESSION['id_outlet'] !== '0') {
		header("Location: index");
	}


	if (isset($_POST['submit'])) {
		if (ubahTransaksi($_POST) > 0) {
			setAlert('Berhasil!','Data Berhasil Diubah','success');
			header("Location: transaksi_show");
			die;
		}
		else{
			setAlert('Gagal!','Data Gagal Diubah','error');
			header("Location: transaksi_show");
			die;
		}
	}
	$id_outlet = $_SESSION['id_outlet'];
	$id_user = $_SESSION['id_user'];

	$id_transaksi = $_GET['id_transaksi'];
	$sql = "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'";
	$eksekusi = mysqli_query($koneksi, $sql);
	$data = mysqli_fetch_assoc($eksekusi);

	$sql_member = "SELECT * FROM tb_member ORDER BY id_member DESC";
	$eksekusi_member = mysqli_query($koneksi, $sql_member);

	$sql_user = "SELECT * FROM tb_user";
	$eksekusi_user = mysqli_query($koneksi, $sql_user);	

	$data_tanggal 		=  strtotime($data['tanggal']);
	$data_batas_waktu	=  strtotime($data['batas_waktu']);
	$data_tanggal_bayar =  strtotime($data['tanggal_bayar']);

	$pembayaran = ['belum dibayar', 'dibayar'];
	$status = ['baru','proses','selesai','diambil'];

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ubah Transaksi</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5 text-white">
		<div class="row justify-content-center">
			<div class="col-md-6 rounded" style="background-color: #005082;">
				<form method="POST">
					<h3 class="mt-3">UBAH TRANSAKSI</h3>
					<input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi']; ?>">
					<input type="hidden" name="id_outlet" value="<?= $id_outlet; ?>">
					<input type="hidden" name="kode_invoice" value="<?= $data['kode_invoice']; ?>">
					<div class="form-group">
						<label for="id_member">MEMBER</label>
						<select class="form-control" name="id_member" id="id_member">
						<?php while ($data_member = mysqli_fetch_array($eksekusi_member)): ?>
							<?php if ($data['id_member'] == $data_member['id_member']): ?>
								<option value="<?= $data_member['id_member']; ?>" selected><?= $data_member['nama_member']; ?></option>
							<?php else: ?>
								<option value="<?= $data_member['id_member']; ?>"><?= $data_member['nama_member']; ?></option>
							<?php endif ?>
						<?php endwhile ?>
						</select>
					</div>
					<div class="form-group">
						<label for="tanggal">TANGGAL</label>
						<input class="form-control" type="datetime-local" name="tanggal" value="<?= date('Y-m-d\TH:i', $data_tanggal); ?>">
					</div>
					<div class="form-group">
						<label for="batas_waktu">BATAS WAKTU</label>
						<input class="form-control" type="datetime-local" name="batas_waktu" value="<?= date('Y-m-d\TH:i', $data_batas_waktu); ?>">
					</div>
				<?php if ($data['dibayar'] == 'dibayar'): ?>
					<div class="form-group">
						<label for="tanggal_bayar">TANGGAL BAYAR</label>
						<input disabled class="form-control" type="datetime-local" name="tanggal_bayar" value="<?= date('Y-m-d\TH:i', $data_tanggal_bayar); ?>">
						<input class="form-control" type="hidden" name="tanggal_bayar" value="<?= date('Y-m-d\TH:i', $data_tanggal_bayar); ?>">
					</div>
				<?php else: ?>
					<div class="form-group">
						<label for="tanggal_bayar">TANGGAL BAYAR</label>
						<input class="form-control" type="datetime-local" name="tanggal_bayar">
					</div>
				<?php endif ?>
				<?php if ($data['dibayar'] == 'belum dibayar'): ?>
					<div class="form-group">
						<label for="biaya_tambahan">BIAYA TAMBAHAN</label>
						<input class="form-control" type="number" name="biaya_tambahan" value="<?= $data['biaya_tambahan']; ?>">
					</div>
					<div class="form-group">
						<label for="diskon">DISKON %</label>
						<input class="form-control" type="number" name="diskon" value="<?= $data['diskon']; ?>">
					</div>
					<div class="form-group">
						<label for="pajak">PAJAK %</label>
						<input class="form-control" type="number" name="pajak" value="<?= $data['pajak']; ?>">
					</div>
				<?php else: ?>
					<input type="hidden" name="biaya_tambahan" value="<?= $data['biaya_tambahan']; ?>">
					<input type="hidden" name="diskon" value="<?= $data['diskon']; ?>">
					<input type="hidden" name="pajak" value="<?= $data['pajak']; ?>">
				<?php endif ?>
					<div class="form-group">
						<label for="status">STATUS</label>
						<select name="status" id="status" class="form-control">\
						<?php foreach ($status as $data_status): ?>
							<?php if ($data['status'] == $data_status): ?>
								<option value="<?= $data_status; ?>" selected><?= ucwords($data_status); ?></option>
							<?php else: ?>
								<option value="<?= $data_status; ?>"><?= ucwords($data_status); ?></option>
							<?php endif ?>
						<?php endforeach ?>
						</select>
					</div>
					<div class="form-group">
						<label for="dibayar">PEMBAYARAN</label>
						<select disabled name="dibayar" id="dibayar" class="form-control">
						<?php foreach ($pembayaran as $data_bayar): ?>
							<?php if ($data['dibayar'] == $data_bayar): ?>
								<option value="<?= $data_bayar; ?>" selected><?= ucwords($data_bayar); ?></option>
							<?php else: ?>
								<option value="<?= $data_bayar; ?>"><?= ucwords($data_bayar); ?></option>
							<?php endif ?>
						<?php endforeach ?>
						</select>
					</div>
					<input type="hidden" value="<?= $id_user; ?>" name="id_user">
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="submit">UBAH <i class="fa fa-paper-plane"></i></button>
						<a class="btn btn-outline-primary" href="transaksi_show">BATAL</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>