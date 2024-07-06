<?php 
	
	session_start();

	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "db_laundry";

	$koneksi = mysqli_connect($host,$user,$password,$database);

	date_default_timezone_set('asia/jakarta');

	function tambahUser($data){
		global $koneksi;
		$nama_user = ucwords(strtolower($data['nama_user']));
		$username = $data['username'];
		$password = $data['password'];
		$password2 = $data['password2'];
		$id_outlet = $data['id_outlet'];
		$role = $data['role'];

		$result = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username'");

		if (mysqli_fetch_assoc($result)) {
			setAlert('Gagal!','Username Telah Digunakan','error');
			header("Location: user_tambah");
			die;
		}
		if ($password !== $password2) {
			setAlert('Gagal!','Konfirmasi Password Salah','error');
			header("Location: user_tambah");
			die;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO tb_user VALUES('','$nama_user','$username','$password','$id_outlet','$role')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);

	}

	function tambahOutlet($data){
		global $koneksi;
		$nama_outlet = ucwords(strtolower($data['nama_outlet']));
		$alamat_outlet = $data['alamat_outlet'];
		$telp_outlet = $data['telp_outlet'];

		$result = mysqli_query($koneksi, "SELECT * FROM tb_outlet WHERE nama_outlet = '$nama_outlet'");

		if (mysqli_fetch_assoc($result)) {
			echo "
			<script>
			alert('Nama Outlet Sudah Digunakan!')
			document.location.href='outlet_tambah'
			</script>
			";
		}

		$sql = "INSERT INTO tb_outlet VALUES('','$nama_outlet','$alamat_outlet','$telp_outlet')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function tambahPaket($data){
		global $koneksi;
		$id_outlet = $data['id_outlet'];
		$jenis = $data['jenis'];
		$nama_paket = ucwords(strtolower($data['nama_paket']));
		$harga = $data['harga'];

		$result = mysqli_query($koneksi, "SELECT * FROM tb_paket WHERE nama_paket = '$nama_paket'");

		if (mysqli_fetch_assoc($result)) {
			echo "
			<script>
			alert('Nama Paket Sudah Digunakan!')
			</script>
			";
		}

		$sql = "INSERT INTO tb_paket VALUES('','$id_outlet','$jenis','$nama_paket','$harga')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function tambahMember($data){
		global $koneksi;
		$nama_member = ucwords(strtolower($data['nama_member']));
		$alamat_member = $data['alamat_member'];
		$jenis_kelamin = $data['jenis_kelamin'];
		$telp_member = $data['telp_member'];

		$result = mysqli_query($koneksi, "SELECT * FROM tb_member WHERE nama_member = '$nama_member'");

		if (mysqli_fetch_assoc($result)) {
			echo "
			<script>
			alert('Nama Pelanggan Sudah Digunakan!')
			</script>
			";	
		}

		$sql = "INSERT INTO tb_member VALUES('','$nama_member','$alamat_member','$jenis_kelamin','$telp_member')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function tambahTransaksi($data){
		global $koneksi;
		$id_outlet = $data['id_outlet'];
		$kode_invoice = 'INV' . date('mdHis') . random_int(00, 99);
		$id_member = $data['id_member'];
		$tanggal = $data['tanggal'];
		$batas_waktu = $data['batas_waktu'];
		$biaya_tambahan = $data['biaya_tambahan'];
		$diskon = $data['diskon'];
		$pajak = $data['pajak'];
		$status = $data['status'];
		$id_user = $data['id_user'];


		$sql = "INSERT INTO tb_transaksi VALUES('','$id_outlet','$kode_invoice','$id_member','$tanggal','$batas_waktu',NULL,'$biaya_tambahan','$diskon','$pajak','$status','belum dibayar','$id_user')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_insert_id($koneksi);
	}

	function tambahDetailTransaksi($data){
		global $koneksi;
		$id_transaksi 	= $data['id_transaksi'];
		$id_paket		= $data['id_paket'];
		$qty 			= $data['qty'];
		$keterangan 	= $data['keterangan'];

		$sql = "INSERT INTO tb_detail_transaksi VALUES('','$id_transaksi','$id_paket','$qty','$keterangan')";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function ubahUser($data){
		global $koneksi;
		$id_user = $data['id_user'];
		$nama_user = ucwords(strtolower($data['nama_user']));
		$username = $data['username'];
		$password = $data['password'];
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$password2 = $data['password2'];
		$id_outlet = $data['id_outlet'];
		$role = $data['role'];
		$password_lama = $data['password_lama'];

		$result = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username'");
		$fetch = mysqli_fetch_assoc($result);
		$password_lama_verify = password_verify($password_lama, $fetch['password']);

		if ($password !== $password2) {
			echo "
			<script>
			alert('Konfirmasi Password tidak sama!')
			</script>
			";
			return false;
		}

		if ($password_lama_verify) {
			$sql = "UPDATE tb_user SET nama_user = '$nama_user', password = '$password_hash', id_outlet = '$id_outlet', role = '$role' WHERE id_user = '$id_user'";
			$eksekusi = mysqli_query($koneksi, $sql);

			return mysqli_affected_rows($koneksi);
		}else{
			echo "
			<script>
			alert('Password Lama tidak benar!')
			</script>
			";
			return false;
		}

	}

	function ubahOutlet($data){
		global $koneksi;
		$id_outlet = $data['id_outlet'];
		$nama_outlet = ucwords(strtolower($data['nama_outlet']));
		$alamat_outlet = $data['alamat_outlet'];
		$telp_outlet = $data['telp_outlet'];

		$sql = "UPDATE tb_outlet SET nama_outlet = '$nama_outlet', alamat_outlet = '$alamat_outlet', telp_outlet = '$telp_outlet' WHERE id_outlet = '$id_outlet'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function ubahPaket($data){
		global $koneksi;
		$id_paket = $data['id_paket'];
		$id_outlet = $data['id_outlet'];
		$jenis = $data['jenis'];
		$nama_paket = ucwords(strtolower($data['nama_paket']));
		$harga = $data['harga'];

		$sql = "UPDATE tb_paket SET id_outlet = '$id_outlet', jenis = '$jenis', nama_paket = '$nama_paket', harga = '$harga' WHERE id_paket = '$id_paket'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function ubahMember($data){
		global $koneksi;
		$id_member = $data['id_member'];
		$nama_member = ucwords(strtolower($data['nama_member']));
		$alamat_member = $data['alamat_member'];
		$jenis_kelamin = $data['jenis_kelamin'];
		$telp_member = $data['telp_member'];

		$sql = "UPDATE tb_member SET nama_member = '$nama_member', alamat_member = '$alamat_member', jenis_kelamin = '$jenis_kelamin', telp_member = '$telp_member' WHERE id_member = '$id_member'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function ubahTransaksi($data){
		global $koneksi;
		$id_transaksi = $data['id_transaksi'];
		$id_outlet = $data['id_outlet'];
		$kode_invoice = $data['kode_invoice'];
		$id_member = $data['id_member'];
		$tanggal = $data['tanggal'];
		$batas_waktu = $data['batas_waktu'];
		$tanggal_bayar = $data['tanggal_bayar'];
		$biaya_tambahan = $data['biaya_tambahan'];
		$diskon = $data['diskon'];
		$pajak = $data['pajak'];
		$status = $data['status'];
		$id_user = $data['id_user'];

		$sql = "UPDATE tb_transaksi SET id_outlet = '$id_outlet', kode_invoice = '$kode_invoice', id_member = '$id_member', tanggal = '$tanggal', batas_waktu = '$batas_waktu', tanggal_bayar = '$tanggal_bayar', biaya_tambahan = '$biaya_tambahan', diskon = '$diskon', pajak = '$pajak', status = '$status', id_user = '$id_user' WHERE id_transaksi = '$id_transaksi'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function ubahDetailTransaksi($data){
		global $koneksi;
		$id_detail_transaksi = $data['id_detail_transaksi'];
		$id_paket = $data['id_paket'];
		$qty = $data['qty'];
		$keterangan = $data['keterangan'];

		$sql = "UPDATE tb_detail_transaksi SET id_paket = '$id_paket', qty = '$qty', keterangan = '$keterangan' WHERE tb_detail_transaksi.id_detail_transaksi = '$id_detail_transaksi'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function hapusOutlet($id){
		global $koneksi;
		$sql = "DELETE FROM tb_outlet WHERE id_outlet = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function hapusUser($id){
		global $koneksi;
		$sql = "DELETE FROM tb_user WHERE id_user = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}
	
	function hapusPaket($id){
		global $koneksi;
		$sql = "DELETE FROM tb_paket WHERE id_paket = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function hapusMember($id){
		global $koneksi;
		$sql = "DELETE FROM tb_member WHERE id_member = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function hapusTransaksi($id){
		global $koneksi;
		$sql = "DELETE FROM tb_transaksi WHERE id_transaksi = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function hapusDetailTransaksi($id){
		global $koneksi;
		$sql = "DELETE FROM tb_detail_transaksi WHERE id_detail_transaksi = '$id'";
		$eksekusi = mysqli_query($koneksi, $sql);

		return mysqli_affected_rows($koneksi);
	}

	function setAlert($title='',$text='',$type='',$buttons=''){

		$_SESSION["alert"]["title"]		= $title;
		$_SESSION["alert"]["text"] 		= $text;
		$_SESSION["alert"]["type"] 		= $type;
		$_SESSION["alert"]["buttons"]	= $buttons; 

	}

	if (isset($_SESSION['alert'])) {

		function alert(){
			$title 		= $_SESSION["alert"]["title"];
			$text 		= $_SESSION["alert"]["text"];
			$type 		= $_SESSION["alert"]["type"];
			$buttons	= $_SESSION["alert"]["buttons"];

			echo"
			<div id='msg' data-title='".$title."' data-type='".$type."' data-text='".$text."' data-buttons='".$buttons."'></div>
			<script>
				let title 		= $('#msg').data('title');
				let type 		= $('#msg').data('type');
				let text 		= $('#msg').data('text');
				let buttons		= $('#msg').data('buttons');

				if(text != '' && type != '' && title != ''){
					Swal.fire({
						title: title,
						text: text,
						icon: type,
					});
				}
			</script>
			";
			unset($_SESSION["alert"]);
		}
	}
 ?>