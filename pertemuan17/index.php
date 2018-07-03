<?php 
session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}
require 'functions.php';
$mahasiswa = query("SELECT *FROM mahasiswa ORDER BY id DESC"); // untuk mendapat semua data dari DB, urut dari id yg besar

// tombol cari diklik
if (isset($_POST["cari"])){
	$mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>
<body>

<a href="logout.php">Logout</a>
<h1>Daftar Mahasiswa</h1>



<a href="tambah.php">Tambah Data Mahasiswa</a>
<br><br>

<!-- POST = data ga tampil di URL -->
<form action="" method="post">
	<input type="text" name="keyword" size="30" autofocus placeholder="masukkan keyword pencarian!" autocomplete="off"> 
	<!-- autofocus biar langsung ke klik pas buka -->
	<button type="submit" name="cari">Cari!</button>
</form>
<br>


<table border="1" cellpadding="10" cellspacing="0">
	
	<tr>
		<th>No.</th>
		<th>Aksi</th>
		<th>Foto</th>
		<th>NIM</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Jurusan</th>
	</tr>	

	<?php $i = 1; ?>
	<?php foreach ($mahasiswa as $row): ?>
	<tr>
		<td><?= $i; ?></td>
		<td>
			<a href="ubah.php?id=<?php echo $row["id"]; ?>">ubah</a> |
			<a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('anda yakin akan menghapus data?');">hapus</a>
		</td>
		<td><img src="img/<?php echo $row["gambar"]; ?>" width="80"></td>
		<td><?php echo $row["nim"]; ?></td>
		<td><?php echo $row["nama"]; ?></td>
		<td><?php echo $row["email"]; ?></td>
		<td><?php echo $row["jurusan"]; ?></td>
	</tr>
	<?php $i++; ?>
	<?php endforeach; ?>

</table>

</body>
</html>