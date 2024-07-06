<?php 

	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form.php");
	}

	//kunci akses halaman
	if ($_SESSION['role'] !== 'admin') {
		header("Location: laundry_show.php");
	}


	$id_outlet = $_SESSION['id_outlet'];

	if ($_SESSION['id_outlet'] > 0) {
		$sql = "SELECT * FROM tb_user
			INNER JOIN tb_outlet ON tb_user.id_outlet = tb_outlet.id_outlet
			WHERE tb_outlet.id_outlet = '$id_outlet' ORDER BY id_user DESC
			";
		$eksekusi = mysqli_query($koneksi, $sql);
	}else{
		$sql = "SELECT * FROM tb_user
				INNER JOIN tb_outlet ON tb_user.id_outlet = tb_outlet.id_outlet
				ORDER BY id_user DESC
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
	<title>User</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>
	<div class="container mt-5 mb-5">
		<h3 class="mt-3">USER - 
			<?php if ($data_outlet == 0) {
		        echo "Management Laundry";
		      } else{
		        echo $data_outlet['nama_outlet'];
		      } ?>
		</h3>
		<table class="table table-striped" id="Table">
			<thead class="text-white" style="background-color: #3282b8">
				<tr>
					<th width="1%">NO</th>
					<th>NAMA</th>
					<?php if ($data_outlet == 0): ?>
						<th>OUTLET</th>
					<?php endif ?>
					<th>TUGAS</th>
					<th width="1%">AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; while ($data = mysqli_fetch_array($eksekusi)) : ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= ucwords($data['nama_user']); ?></td>
					<?php if ($data_outlet == 0): ?>
						<td><?= $data['nama_outlet']; ?></td>
					<?php endif ?>
					<td><?= ucwords($data['role']); ?></td>
					<td>
						<a id="tombol-hapus" href="user_ubah.php?id_user=<?= $data['id_user']; ?>" class="badge badge-success"><i class="fa fa-edit"></i></a>
						<a onclick="return confirm('Apakah Anda Ingin Menghapus <?= ucwords($data['username']); ?> ?')" href="user_hapus.php?id_user=<?= $data['id_user']; ?>" class="badge badge-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php endwhile ?>
			</tbody>
		</table>
	</div>
</body>

<?php include 'footer.php'; ?>

</html>
