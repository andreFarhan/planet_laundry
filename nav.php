  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrap/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="font-awesome/css/all.min.css">
<?php 

  $id_outlet = $_SESSION['id_outlet'];
  $sql_outlet = "SELECT * FROM tb_outlet WHERE id_outlet = '$id_outlet'";
  $eksekusi_outlet = mysqli_query($koneksi, $sql_outlet);
  $data_outlet = mysqli_fetch_assoc($eksekusi_outlet);
 ?>
<style type="text/css">
    .container {
        margin-top: 30px;
    }
    .dropdown-toggle,
    .dropdown-menu {
        border-radius: 0px !important;
    }
    .dropdown-item:hover {
        color: white;
        background-color: #0f4c81;
    }
    .btn-danger {
        width: 55%;
    }
    .dropdown:hover>.dropdown-menu {
      display: block;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0f4c75">
  <a class="navbar-brand text-white">
      <?php if ($data_outlet == 0) {
        echo "Management Laundry";
      } else{
        echo $data_outlet['nama_outlet'];
      } ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php if ($_SESSION['role'] !== 'owner'): ?>
      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/laundry_show'): ?>
        <li class="nav-item active">
          <a class="nav-link" href="laundry_show"><i class="fa fa-home"></i> Home</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="laundry_show"><i class="fa fa-home"></i> Home</a>
        </li>
      <?php endif ?>
    <?php endif ?>
      
    <?php if ($_SESSION['id_outlet'] == '0'): ?>
      
      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/outlet_show' OR $_SERVER['REQUEST_URI'] == '/planet_laundry/outlet_tambah' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/outlet_ubah.php'): ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-store"></i> Outlet
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="outlet_show"><i class="fas fa-store"></i> Outlet</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="outlet_tambah"><i class="fa fa-plus-square"></i> Tambah Outlet</a>
        <?php endif ?>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-store"></i> Outlet
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="outlet_show"><i class="fas fa-store"></i> Outlet</a>
        <?php if ($_SESSION['role'] == 'admin'): ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="outlet_tambah"><i class="fa fa-plus-square"></i> Tambah Outlet</a>
        <?php endif ?>
        </div>
      </li>
      <?php endif ?>

    <?php endif ?>
  
    <?php if ($_SESSION['id_outlet'] == '0' OR $_SESSION['role'] == 'admin') : ?>
      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/user_show' OR $_SERVER['REQUEST_URI'] == '/planet_laundry/user_tambah' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/user_ubah.php'): ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user-alt"></i> User
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="user_show"><i class="fa fa-user-alt"></i> User</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="user_tambah"><i class="fa fa-user-plus"></i> Tambah User</a>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user-alt"></i> User
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="user_show"><i class="fa fa-user-alt"></i> User</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="user_tambah"><i class="fa fa-user-plus"></i> Tambah User</a>
        </div>
      </li>
      <?php endif ?>

      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/paket_show' OR $_SERVER['REQUEST_URI'] == '/planet_laundry/paket_tambah' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/paket_ubah.php'): ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-box"></i> Paket
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="paket_show"><i class="fa fa-box"></i> Paket</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="paket_tambah"><i class="fa fa-plus-square"></i> Tambah Paket</a>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-box"></i> Paket
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="paket_show"><i class="fa fa-box"></i> Paket</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="paket_tambah"><i class="fa fa-plus-square"></i> Tambah Paket</a>
        </div>
      </li>
      <?php endif ?>
    <?php endif ?>  

    <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'kasir'): ?>
      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/member_show' OR $_SERVER['REQUEST_URI'] == '/planet_laundry/member_tambah' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/member_ubah.php' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/member_show.php'): ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-users"></i> Member
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="member_show"><i class="fa fa-users"></i> Member</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="member_tambah"><i class="fa fa-user-plus"></i> Tambah Member</a>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-users"></i> Member
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="member_show"><i class="fa fa-users"></i> Member</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="member_tambah"><i class="fa fa-user-plus"></i> Tambah Member</a>
        </div>
      </li>
      <?php endif ?>

      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/transaksi_show' OR $_SERVER['REQUEST_URI'] == '/planet_laundry/transaksi_tambah' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/transaksi_ubah.php' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/detail_transaksi_show.php' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/detail_transaksi_tambah.php' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/detail_transaksi_ubah.php' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/pembayaran.php'): ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-shopping-cart"></i> transaksi
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="transaksi_show"><i class="fa fa-shopping-cart"></i> transaksi</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="transaksi_tambah"><i class="fa fa-cart-plus"></i> Tambah transaksi</a>
        </div>
      </li>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-shopping-cart"></i> transaksi
        </a>
        <div class="dropdown-menu mt-n2" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="transaksi_show"><i class="fa fa-shopping-cart"></i> transaksi</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="transaksi_tambah"><i class="fa fa-cart-plus"></i> Tambah transaksi</a>
        </div>
      </li>
      <?php endif ?>
    <?php endif ?>

    <?php if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'owner') : ?>
      <?php if ($_SERVER['REQUEST_URI'] == '/planet_laundry/laporan_penghasilan' OR $_SERVER['SCRIPT_NAME'] == '/planet_laundry/laporan_penghasilan.php'): ?>
        <li class="nav-item active">
          <a class="nav-link" href="laporan_penghasilan"><i class="fa fa-file"></i> Laporan</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="laporan_penghasilan"><i class="fa fa-file"></i> Laporan</a>
        </li>
      <?php endif ?>
    <?php endif ?>


      <li class="nav-item">
        <a onclick="return confirm('Apakah anda ingin keluar?')" class="nav-link" href="logout"><i class="fa fa-door-open"></i> Keluar</a>
      </li>
    </ul>
      <?php 
        $role     = ucwords($_SESSION['role']);
        $username = ucwords($_SESSION['username']);
       ?>
      <b class="mr-sm-2 mb-n1 text-white"><?= $role,' ',$username; ?></b>
  </div>
</nav>