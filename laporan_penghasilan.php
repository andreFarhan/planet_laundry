<?php 
	include 'functions.php';

	if (isset($_GET["filter"])) {
		$tgl_dari 		= $_GET["tgl_dari"];
		$tgl_sampai 	= $_GET["tgl_sampai"].' 23:59:59';
		$sql = "SELECT * FROM tb_transaksi 
			INNER JOIN tb_member ON tb_transaksi.id_member = tb_member.id_member 
			INNER JOIN tb_detail_transaksi ON tb_detail_transaksi.id_transaksi = tb_transaksi.id_transaksi 
			INNER JOIN tb_paket ON tb_detail_transaksi.id_paket = tb_paket.id_paket 
			INNER JOIN tb_pembayaran ON tb_pembayaran.id_transaksi = tb_transaksi.id_transaksi
			WHERE tb_transaksi.tanggal BETWEEN '$tgl_dari' AND '$tgl_sampai'
			GROUP BY tb_transaksi.id_transaksi
			ORDER BY tb_transaksi.kode_invoice DESC
			";
		$eksekusi = mysqli_query($koneksi, $sql);
		echo mysqli_error($koneksi);
	}

	if ($_SESSION['role'] == 'kasir') {
		header('Location:index.php');
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Laporan Penghasilan</title>

	<link rel="icon" href="img/laundry-management.png">
	<style>
	@media print{ 
		.hilang{
			display: none;
			}
		#hilang{
			display: none;
			}
		}
	}
	</style>
</head>
<body style="background: #f0f0f0">
	<?php include 'nav.php'; ?>
<div class="container mt-3">
	<div class="panel">
		<div class="panel-heading">
			<h4>Filter Laporan</h4>
		</div>
		<div class="panel-body">		
		<?php if (isset($_GET['filter'])): ?>
			<button id="hilang" class="btn btn-success mt-2 mb-2" onclick="window.print()">PRINT</button>
		<?php endif ?>
			<form action="laporan_penghasilan.php" method="get">
				<table class="table table-bordered table-striped">
					<tbody>
					<tr>				
						<th>Dari Tanggal</th>
						<th>Sampai Tanggal</th>							
						<th width="1%" class="hilang"></th>
					</tr>
					<tr>
						<td>
						<?php if (isset($_GET['filter'])): ?>
							<input type="date" name="tgl_dari" class="form-control" value="<?= $tgl_dari; ?>">
						<?php else: ?>
							<input type="date" name="tgl_dari" class="form-control">
						<?php endif ?>
						</td>
						<td>
						<?php if (isset($_GET['filter'])): ?>
							<input type="date" name="tgl_sampai" class="form-control" value="<?= date('Y-m-d',strtotime($tgl_sampai)); ?>">
						<?php else: ?>
							<input type="date" name="tgl_sampai" class="form-control">
						<?php endif ?>
						</td>
						<td class="hilang">
							<input type="submit" class="btn btn-primary" name="filter" value="Filter">
						</td>
					</tr>

				</tbody>
				</table>

				<?php if (isset($_GET['filter'])): ?>
					<table  style="width: 110%; margin-left: -5%" id="Table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>NO INVOICE</th>
								<th>Nama member</th>
								<th>Tanggal Transaksi</th>
								<th>Batas Waktu</th>
								<th>Tanggal Bayar</th>
								<th>Harga Transaksi</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							<?php while ($data = mysqli_fetch_array($eksekusi)): ?>
							<?php if ($data['dibayar'] == 'dibayar'): ?>
							<tr>
								<td><?= $data['kode_invoice']; ?></td>
								<td><?= $data['nama_member']; ?></td>
								<td><?= $data['tanggal']; ?></td>
								<td><?= $data['batas_waktu']; ?></td>
								<td><?= $data['tanggal_bayar']; ?></td>
								<td>Rp <?= str_replace(",", ".", number_format($data['total_pembayaran'])); ?></td>
								<td><?= ucwords($data["status"]); ?></td>
							</tr>
							<?php endif ?>
							<?php endwhile ?>
						</tbody>
						<div class="row">
							<div class="col">
								<?php 
									$sql_total_keuntungan = "SELECT SUM(total_pembayaran) as total_pembayaran FROM tb_pembayaran
									INNER JOIN tb_transaksi ON tb_pembayaran.id_transaksi = tb_transaksi.id_transaksi
									WHERE tanggal BETWEEN '$tgl_dari' AND '$tgl_sampai'
									";
									$eksekusi_total_keuntungan = mysqli_query($koneksi, $sql_total_keuntungan);
									$data_total_keuntungan = mysqli_fetch_assoc($eksekusi_total_keuntungan);
								 ?>
								 <p class="font-weight-bold">Penghasilan/ Laba : Rp. <?= str_replace(",", ".", number_format($data_total_keuntungan['total_pembayaran'])); ?></p>
							</div>
						</div>
					</table>
				<?php endif ?>
			</form>
			
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>