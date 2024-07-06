<?php 
  include 'functions.php';

  $id_user = $_SESSION['id_user'];
  $user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id_user = '$id_user'");
  $data_user = mysqli_fetch_assoc($user);
  
  $i=1;$jml_total=0;

  if ($_SESSION['role'] == 'owner') {
    header('Location: index.php');
  }

  $id_transaksi = $_GET['id_transaksi'];
  $sql_paket = "SELECT *, (SELECT COUNT(nama_paket) FROM tb_paket) as jumlah_jenis_paket FROM tb_detail_transaksi
    INNER JOIN tb_paket ON tb_paket.id_paket = tb_detail_transaksi.id_paket
    WHERE id_transaksi = '$id_transaksi'
    ";
  $eksekusi_paket = mysqli_query($koneksi, $sql_paket);

  $sql_detail = mysqli_query($koneksi, "SELECT * FROM tb_detail_transaksi");
  $fetch_detail = mysqli_fetch_assoc($sql_detail);

  $sql_transaksi = mysqli_query($koneksi, "SELECT * FROM tb_transaksi INNER JOIN tb_member ON tb_transaksi.id_member =  tb_member.id_member WHERE id_transaksi = '$id_transaksi'");
  $fetch_transaksi = mysqli_fetch_assoc($sql_transaksi);

  $sql_total_harga = mysqli_query($koneksi, "SELECT SUM(harga*qty) as jml_harga FROM tb_paket
  INNER JOIN tb_detail_transaksi ON tb_detail_transaksi.id_paket = tb_paket.id_paket
  INNER JOIN tb_transaksi ON tb_transaksi.id_transaksi = tb_detail_transaksi.id_transaksi
  WHERE tb_transaksi.id_transaksi = '$id_transaksi'
  ");
  $eksekusi_total_harga = mysqli_fetch_assoc($sql_total_harga);
  $total_harga = $eksekusi_total_harga['jml_harga'];


  if (isset($_POST['bayar'])) {
    $transaksi_harga = $_POST['transaksi_harga'];
    $nama_member = $_POST['nama_member'];
    $uang_bayar = $_POST['uang_bayar'];
    if ($uang_bayar >= $transaksi_harga) {
      $kembalian = $uang_bayar - $transaksi_harga;
      $id_transaksi = $_POST['id_transaksi'];
      $sql_transaksi = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'");
      $fetch_transaksi = mysqli_fetch_assoc($sql_transaksi);
      
      $cek_sql_update = mysqli_affected_rows($koneksi);

    } else {
      $kembalian = $uang_bayar - $transaksi_harga;
        setAlert('Gagal!','Uang Yang Dibayar Kurang!','error');
        header("Location: pembayaran.php?id_transaksi=$id_transaksi");
        die;
    }
  }

  if (isset($_POST['selesai'])) {
    $transaksi_harga = $_POST['transaksi_harga'];
    $uang_bayar = $_POST['uang_bayar'];
    $kembalian = $uang_bayar - $transaksi_harga;
    $id_transaksi = $_POST['id_transaksi'];

    $sql_pembayaran = mysqli_query($koneksi, "INSERT INTO tb_pembayaran VALUES ('', '$total_harga', '$uang_bayar', '$kembalian', '$id_user', '$id_transaksi')");

    $tanggal_bayar = date('Y-m-d\TH:i:s');
    $sql_bayar = mysqli_query($koneksi, "UPDATE tb_transaksi SET tanggal_bayar = '$tanggal_bayar', dibayar = 'dibayar' WHERE id_transaksi = '$id_transaksi'");

    setAlert('Berhasil!','Pembayaran Berhasil','success');
    header("Location: invoice.php?id_transaksi=$id_transaksi");
    die;
    
  }

  $biaya_tambahan = $fetch_transaksi['biaya_tambahan'];
  $pajak = $fetch_transaksi['pajak']/100*$total_harga;
  $diskon = $fetch_transaksi['diskon']/100*$total_harga+$biaya_tambahan;

  $transaksi_harga = ($total_harga+$biaya_tambahan+$pajak)-$diskon;

  $rows   = [];
  while ($row = mysqli_fetch_array($eksekusi_paket)){
    $row["subtotal"]  = $row['harga'] * $row['qty'];
    $rows[]           = $row;
    $total            = $row['harga'] * $row['qty'];
    $jml_total        = $jml_total + $total;
  };

?>

<!DOCTYPE html>
<html lang="en" id="page-top">
  <head>
    <title>Pembayaran - Invoice No. <?= $fetch_transaksi['id_transaksi']; ?></title>
    <link rel="icon" href="img/laundry-management.png">
  </head>
  <body>
    <?php include 'nav.php'; ?>
      <div class="container mt-5">
        <h1>Pembayaran</h1>
        <div class="row mb-3">
          <div class="col-md-4 mx-2 p-4 rounded text-white" style="background-color: #005082;">
            <h5>Pembayaran - <?= $fetch_transaksi['kode_invoice']; ?></h5>
            <form method="post">
              <?php if (isset($_POST['bayar'])): ?>
                <input type="hidden" name="id_transaksi" value="<?= $id_transaksi; ?>">
                <input type="hidden" name="uang_bayar" value="<?= $uang_bayar; ?>">
              <?php endif ?>
              <input type="hidden" name="id_transaksi" value="<?= $fetch_transaksi['id_transaksi']; ?>">
              <input type="hidden" name="nama_member" value="<?= $fetch_transaksi['nama_member']; ?>">
              
              <div class="form-group">
                <label for="Nama member">Nama member</label>
                <?php if (isset($_POST['bayar'])): ?>
                  <input style="cursor: not-allowed;" disabled value="<?= $nama_member; ?>" type="text" id="Nama member" class="form-control" name="Nama member">
                <?php else: ?>
                  <input style="cursor: not-allowed;" disabled value="<?= $fetch_transaksi['nama_member']; ?>" type="text" id="Nama member" class="form-control" name="Nama member">
                <?php endif ?>
              </div>

              <div class="form-group">
                <label for="total_pembayaran">Total Harga</label>
                <input style="cursor: not-allowed;" type="text" disabled value="Rp <?= str_replace(",", ".", number_format($jml_total)); ?>" id="total_pembayaran" class="form-control text-right">
              </div>
              
              <div class="form-group">
                <label for="biaya_tambahan">Biaya Tambahan</label>
                <input style="cursor: not-allowed;" type="text" disabled value="+ Rp <?= str_replace(",", ".", number_format($biaya_tambahan)); ?>" id="biaya_tambahan" class="form-control text-right">
              </div>

              <div class="form-group">
                <label for="pajak">Pajak (+<?= $fetch_transaksi['pajak']; ?>%)</label>
                <input style="cursor: not-allowed;" type="text" disabled value="+ Rp <?= str_replace(",", ".", number_format($pajak)); ?>" id="pajak" class="form-control text-right">
              </div>

              <div class="form-group">
                <label for="diskon">Diskon (-<?= $fetch_transaksi['diskon']; ?>%)</label>
                <input style="cursor: not-allowed;" type="text" disabled value="- Rp <?= str_replace(",", ".", number_format($diskon)); ?>" id="diskon" class="form-control text-right">
              </div>

              <hr style="border: 1px solid">

              <div class="form-group">
                <label for="transaksi_harga"><b>TOTAL PEMBAYARAN</b></label>
                <input style="cursor: not-allowed;" type="text" disabled value="Rp <?= str_replace(",", ".", number_format($transaksi_harga)); ?>" id="transaksi_harga" class="form-control text-right">
              </div>

              <input type="hidden" name="transaksi_harga" value="<?= $transaksi_harga; ?>">

              <hr style="border: 1px dotted">

              <div class="form-group">
                <label for="uang_bayar">Uang yang dibayar</label>
                <?php if (isset($_POST['bayar'])): ?>
                <input style="cursor: not-allowed;" disabled type="text" id="uang_bayar" class="form-control text-right" name="uang_bayar" value="Rp <?= str_replace(",", ".", number_format($uang_bayar)); ?>">
                <?php else: ?>
                <input type="number" id="uang_bayar" class="form-control text-right" name="uang_bayar">
                <?php endif ?>
              </div>
              <?php if (isset($_POST['bayar'])): ?>
                <div class="form-group">
                  <label for="kembalian">Kembalian</label>
                  <input style="cursor: not-allowed;" disabled type="text" id="kembalian" class="form-control text-right" name="kembalian" value="Rp <?= str_replace(",", ".", number_format($kembalian)); ?>">
                </div>
              <?php endif ?>
              <?php if (isset($_POST['bayar'])): ?>
                <button type="submit" name="selesai" class="btn btn-primary"><i class="fas fa-fw fa-handshake"></i> Selesai</button>
              <?php else: ?>
                <button type="submit" name="bayar" class="btn btn-primary"><i class="fas fa-fw fa-handshake"></i> Bayar</button>
                <a href="transaksi_show" class="btn btn-outline-primary"> Batal</a>
              <?php endif ?>
            </form>
          </div>
          <div class="col-md-7 mx-2 p-4 rounded text-white" style="background-color: #005082;">
            <div class="table-responsive">
              <h4>Daftar Pembelian</h4>
              <table class="table text-white">
                <tr>
                  <th width="1%">No</th>
                  <th>Jenis_paket</th>
                  <th>Keterangan</th>
                  <th>Qty</th>
                  <th width="16%">Harga</th>
                  <th width="16%">Subtotal</th>
                </tr>
                <?php foreach ($rows as $data_paket): ?>
                  <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $data_paket['nama_paket']; ?></td>
                    <td><textarea disabled class="form-control"><?= $data_paket['keterangan']; ?></textarea></td>
                    <td class="text-center"><?= $data_paket['qty']; ?></td>
                    <td>Rp <?= str_replace(",", ".", number_format($data_paket['harga'])); ?></td>
                    <td>Rp <?= str_replace(",", ".", number_format($data_paket['subtotal'])); ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
              <hr style="border: 1px solid">
              <p class="float-right">Total Harga : Rp <?= str_replace(",", ".", number_format($jml_total)); ?></p>
            </div>
          </div>
        </div>
      </div>
  </body>
  <?php include 'footer.php'; ?>
</html>