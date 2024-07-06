<?php 
	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form");
	}

	//kunci akses halaman
	if ($_SESSION['role'] !== 'owner' AND $_SESSION['role'] !== 'admin') {
		header("Location: laundry_show");
	}
	
	$sql = "SELECT * FROM tb_outlet ORDER BY id_outlet DESC";
	$eksekusi = mysqli_query($koneksi, $sql);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Outlet</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5">
		<h3 class="mt-3">OUTLET</h3>
		<table class="table table-striped" id="Table">
			<thead class="text-white" style="background-color: #3282b8">
				<tr>
					<th width="1%w">NO</th>
					<th>NAMA</th>
					<th>ALAMAT</th>
					<th>TELEPON</th>
					<?php if ($_SESSION['role'] == 'admin'): ?>
					<th width="1%">AKSI</th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; while ($data = mysqli_fetch_array($eksekusi)) : ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= $data['nama_outlet']; ?></td>
					<td><?= $data['alamat_outlet']; ?></td>
					<td><?= $data['telp_outlet']; ?></td>
					<?php if ($_SESSION['role'] == 'admin'): ?>
					<td>
						<a class="badge badge-success" href="outlet_ubah.php?id_outlet=<?= $data['id_outlet']; ?>"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('Apakah anda ingin menghapus outlet <?= $data['nama_outlet']; ?> ?! ')" class="badge badge-danger" href="outlet_hapus.php?id_outlet=<?= $data['id_outlet']; ?>"><i class="fa fa-trash"></i></a>
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