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

	$id_outlet = $_SESSION['id_outlet'];

	if ($_SESSION['id_outlet'] > 0) {
		
		$sql = "SELECT * FROM tb_transaksi 
				INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet
				INNER JOIN tb_member ON tb_transaksi.id_member = tb_member.id_member
				INNER JOIN tb_user	 ON tb_transaksi.id_user   = tb_user.id_user
				WHERE tb_outlet.id_outlet = '$id_outlet' ORDER BY id_transaksi DESC
				";
		$eksekusi = mysqli_query($koneksi, $sql);
	}else{

		$sql = "SELECT * FROM tb_transaksi 
				INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet
				INNER JOIN tb_member ON tb_transaksi.id_member = tb_member.id_member
				INNER JOIN tb_user	 ON tb_transaksi.id_user   = tb_user.id_user
				ORDER BY id_transaksi DESC
				";
		$eksekusi = mysqli_query($koneksi, $sql);
	}


	$sql_outlet = "SELECT * FROM tb_outlet WHERE id_outlet = '$id_outlet'";
	$eksekusi_outlet = mysqli_query($koneksi, $sql_outlet);
	$data_outlet = mysqli_fetch_assoc($eksekusi_outlet);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transaksi</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5">
		<h3 class="mt-3">TRANSAKSI - 
			<?php if ($data_outlet == 0) {
		        echo "Management Laundry";
		      } else{
		        echo $data_outlet['nama_outlet'];
		      } ?>
      </h3>
		<table class="table table-striped" id="Table" style="width: 110%; margin-left: -5%">
			<thead class="text-white" style="background-color: #3282b8;">
				<tr>
					<th width="1%">NO</th>
				<?php if ($data_outlet == 0): ?>
					<th>OUTLET</th>
				<?php endif ?>
					<th width="1%">INVOICE</th>
					<th>MEMBER</th>
					<th>TANGGAL</th>
					<th>BATAS_WAKTU</th>
					<th>TANGGAL_BAYAR</th>
					<th width="1%">BAYAR</th>
					<th>STATUS</th>
					<th>USER</th>
					<?php if ($_SESSION['role'] == 'admin'): ?>
					<th width="1%">AKSI</th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; while ($data = mysqli_fetch_array($eksekusi)) : ?>
				<tr>
					<td><?= $i++; ?></td>
				<?php if ($data_outlet == 0): ?>
					<td><?= $data['nama_outlet']; ?></td>
				<?php endif ?>
					<td><a href="detail_transaksi_show.php?id_transaksi=<?= $data['id_transaksi']; ?>" style="text-decoration: none; font-weight: bold;"><?= $data['kode_invoice']; ?></a></td>
					<td><a href="member_show.php?id_member=<?= $data['id_member']; ?>" style="text-decoration: none; font-weight: bold;"><?= $data['nama_member']; ?></a></td>
					<td><?= $data['tanggal']; ?></td>
					<td><?= $data['batas_waktu']; ?></td>
					<td><?= $data['tanggal_bayar']; ?></td>
					<td>
					<?php if ($data['dibayar'] == 'belum dibayar'): ?>
						<a onclick="return confirm('Apakah anda ingin membayar transaksi ini ? ')" href="invoice.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-success">$ Bayar</a>
					<?php else: ?>
						<a href="invoice.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-info text-white">DiBayar</a>
					<?php endif ?>
					<td>
						<form action="transaksi_status.php" method="GET">
							<?php if ($data['status'] == 'baru'): ?>
								<a onclick="return confirm('Apakah Anda Ingin Memproses Pakaian Ini?')" class="badge badge-pill badge-primary" href="transaksi_status.php?id_transaksi=<?= $data['id_transaksi']; ?>">Baru</a>
							<?php elseif ($data['status'] == 'proses'): ?>
								<a onclick="return confirm('Apakah Anda Ingin Menyuci Pakaian Ini?')" class="text-white badge badge-pill badge-warning" href="transaksi_status.php?id_transaksi=<?= $data['id_transaksi']; ?>">Proses</a>
							<?php elseif ($data['status'] == 'selesai'): ?>
								<?php if ($data['dibayar'] == 'belum dibayar'): ?>
									<a onclick="return alert('Mohon Bayar Transaksi Terlebih Dahulu !')" class="badge badge-pill badge-danger text-white">Selesai</a>
								<?php else: ?>
									<a onclick="return confirm('Apakah Anda Ingin Menyelesaikan Pakaian Ini?')" class="badge badge-pill badge-danger" href="transaksi_status.php?id_transaksi=<?= $data['id_transaksi']; ?>">Selesai</a>
								<?php endif ?>
							<?php else : ?>
								<a class="badge badge-pill badge-success" href="detail_transaksi_show.php?id_transaksi=<?= $data['id_transaksi']?>">Diambil</a>
							<?php endif ?>
						</form>
					</td>
					<td><?= ucfirst($data['username']); ?></td>
					<?php if ($_SESSION['role'] == 'admin' OR $_SESSION['id_outlet'] == '0'): ?>
					<td>
						<a href="transaksi_ubah.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="badge badge-success"> <i class="fa fa-edit"></i></a>
						<a onclick="return confirm('Apakah anda ingin menghapus transaksi <?= $data['kode_invoice']; ?> ?')" href="transaksi_hapus.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="badge badge-danger"> <i class="fa fa-trash"></i></a>
						<?php if ($data['dibayar'] == 'belum dibayar'): ?>
							<a href="detail_transaksi_tambah.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="badge badge-primary"> <i class="fa fa-archive"></i></a>
						<?php endif ?>
					</td>
					<?php endif ?>
				</tr>
				<?php endwhile ?>
			</tbody>
		</table>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>