<?php 
	include 'functions.php';

	//cek login
	if ($_SESSION['login'] == 0) {
		header("Location: login_form.php");
	}

	$id_outlet = $_SESSION['id_outlet'];
	$role      = ucwords($_SESSION['role']);
    $nama_user = ucwords($_SESSION['nama_user']);

    if ($id_outlet == '0' ) {
	    $sql = "SELECT * FROM tb_transaksi
		INNER JOIN tb_member ON tb_transaksi.id_member = tb_member.id_member
		INNER JOIN tb_user	 ON tb_transaksi.id_user   = tb_user.id_user
		INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet
		ORDER BY id_transaksi DESC";
		$eksekusi = mysqli_query($koneksi, $sql);
    }else{
	    $sql = "SELECT * FROM tb_transaksi
		INNER JOIN tb_member ON tb_transaksi.id_member = tb_member.id_member
		INNER JOIN tb_user	 ON tb_transaksi.id_user   = tb_user.id_user
		INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet
		WHERE tb_outlet.id_outlet = '$id_outlet'
		ORDER BY id_transaksi DESC";
		$eksekusi = mysqli_query($koneksi, $sql);
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Management</title>
	<link rel="icon" href="img/laundry-management.png">
</head>
<body>
	<?php include 'nav.php'; ?>

	<div class="container mt-3">
		<h2></h2>
	<div class="alert alert-info text-center">
		<h4><b>Selamat Datang <b><?= $role,' ',$nama_user; ?></b></b></h4>
	</div>
	<?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
			<h4>Beranda</h4>
			
			<div class="row">
				
				<div class="col mx-1 text-white bg-info rounded pt-2 pb-2">
					<h1>
						<i class="fa fa-user"></i>
						<span class="pull-right">
							<?php 
    						if ($id_outlet == '0' ) {
								$sql_transaksi = "SELECT *, count(tb_transaksi.id_transaksi) as jml_transaksi FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet";
								$eksekusi_jml_transaksi = mysqli_query($koneksi, $sql_transaksi);
								$data_jml_transaksi = mysqli_fetch_assoc($eksekusi_jml_transaksi);
								echo $data_jml_transaksi['jml_transaksi'];
    						}else{
								$sql_transaksi = "SELECT *, count(tb_transaksi.id_transaksi) as jml_transaksi FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet
									WHERE tb_outlet.id_outlet = '$id_outlet'";
								$eksekusi_jml_transaksi = mysqli_query($koneksi, $sql_transaksi);
								$data_jml_transaksi = mysqli_fetch_assoc($eksekusi_jml_transaksi);
								echo $data_jml_transaksi['jml_transaksi'];
    						} 
							?>
						</span>
					</h1>
						<div>Jumlah Transaksi</div>
				</div>		
				
				<div class="col mx-1 text-white bg-primary rounded pt-2 pb-2">
					<h1>
						<i class="fa fa-retweet"></i> 
						<span class="pull-right">
							<?php 	
    						if ($id_outlet == '0' ) {
								$sql_baru = "SELECT *, count(tb_transaksi.status) as jml_baru FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'baru'";
								$eksekusi_jml_baru = mysqli_query($koneksi, $sql_baru);
								$data_jml_baru = mysqli_fetch_assoc($eksekusi_jml_baru);
								echo $data_jml_baru['jml_baru'];
    						}else{
								$sql_baru = "SELECT *, count(tb_transaksi.status) as jml_baru FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'baru' AND tb_outlet.id_outlet = '$id_outlet'";
								$eksekusi_jml_baru = mysqli_query($koneksi, $sql_baru);
								$data_jml_baru = mysqli_fetch_assoc($eksekusi_jml_baru);
								echo $data_jml_baru['jml_baru'];
							}
							?>
						</span>
					</h1>
					<div>Jumlah Cucian Baru</div>
				</div>		

				<div class="col mx-1 text-white bg-warning rounded pt-2 pb-2">
					<h1>
						<i class="fab fa-algolia"></i> 
						<span class="pull-right">
							<?php 	
    						if ($id_outlet == '0' ) {
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'proses'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
    						}else{
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'proses' AND tb_outlet.id_outlet = '$id_outlet'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
							}
							?>
						</span>
					</h1>
					<div>Jumlah Cucian Dicuci</div>
				</div>		

				<div class="col mx-1 text-white bg-danger rounded pt-2 pb-2">
					<h1>
						<i class="fa fa-info-circle"></i> 
						<span class="pull-right">
							<?php 
    						if ($id_outlet == '0' ) {
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'selesai'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
    						}else{
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'selesai' AND tb_outlet.id_outlet = '$id_outlet'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
							}
							?>
						</span>
					</h1>
					<div>Jumlah Cucian Selesai</div>
				</div>				

				<div class="col mx-1 text-white bg-success rounded pt-2 pb-2">
					<h1>
						<i class="fa fa-check-circle"></i> 
						<span class="pull-right">
							<?php 
    						if ($id_outlet == '0' ) {
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'diambil'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
    						}else{
								$sql_proses = "SELECT *, count(tb_transaksi.status) as jml_proses FROM tb_transaksi INNER JOIN tb_outlet ON tb_transaksi.id_outlet = tb_outlet.id_outlet WHERE status = 'diambil' AND tb_outlet.id_outlet = '$id_outlet'";
								$eksekusi_jml_proses = mysqli_query($koneksi, $sql_proses);
								$data_jml_proses = mysqli_fetch_assoc($eksekusi_jml_proses);
								echo $data_jml_proses['jml_proses'];
							}
							?>
						</span>
					</h1>
					<div>Jumlah Cucian Diambil</div>
				</div>				
			</div>		
	
	<div class="mt-3">
		<div>
			<h4>Riwayat Transaksi Terakhir</h4>
		</div>
		<div>
			<table class="table table-striped" id="Table" style="width: 110%; margin-left: -5%">
			<thead class="text-white" style="background-color: #3282b8;">
				<tr>
					<th width="1%">NO</th>
				<?php if ($data_outlet == 0): ?>
					<th>OUTLET</th>
					<th width="1%">INVOICE</th>
					<th width="15%">MEMBER</th>
					<th width="15%">TANGGAL</th>
					<th width="15%">BATAS_WAKTU</th>
					<th width="15%">TANGGAL_BAYAR</th>
					<th width="1%">BAYAR</th>
					<th>STATUS</th>
					<th>USER</th>
				<?php else: ?>
					<th width="1%">INVOICE</th>
					<th width="15%">MEMBER</th>
					<th width="15%">TANGGAL</th>
					<th width="15%">BATAS WAKTU</th>
					<th width="15%">TANGGAL BAYAR</th>
					<th width="1%">BAYAR</th>
					<th>STATUS</th>
					<th>USER</th>
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
					<td><a href="member_show.php?id_member=<?= $data['id_member']; ?>" style="text-decoration: none; font-weight: bold;"><?= strlen($data['nama_member']) > 12 ? substr($data['nama_member'],0,12)."..." : $data['nama_member']; ?></a></td>
					<td><?= $data['tanggal']; ?></td>
					<td><?= $data['batas_waktu']; ?></td>
					<td><?= $data['tanggal_bayar']; ?></td>
					<td>
					<?php if ($data['dibayar'] == 'belum dibayar'): ?>
						<a onclick="return confirm('Apakah anda ingin membayar transaksi ini ? ')" href="invoice.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="badge badge-pill badge-success">$ Bayar</a>
					<?php else: ?>
						<a href="invoice.php?id_transaksi=<?= $data['id_transaksi']; ?>" class="badge badge-pill badge-info text-white">DiBayar</a>
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
				</tr>
				<?php endwhile ?>
			</tbody>
		</table>
		</div>
	</div>
	<?php endif ?>	
</div>
	
</body>

<?php include 'footer.php'; ?>

</html>