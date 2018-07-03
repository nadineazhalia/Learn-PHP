<?php 
session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

// mengambil data di url
$id = $_GET["id"];

// query data mhs berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// cek apakah tombol subimt udh ditekan atau blm
if (isset($_POST["submit"])) {

	// cek apakah data berhasil diubah atau tidak
	// 1 = berhasil ; -1 = gagal
	if (ubah($_POST) > 0) {
		echo "
		<script>
			alert('data berhasil diubah!');
			document.location.href = 'index.php';
		</script>";
	} else {
		echo "
		<script>
			alert('data gagal diubah!');
			document.location.href = 'index.php';
		</script>";
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data Mahasiswa</title>
</head>
<body>

	<h1>Ubah Data Mahasiswa</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">
		<input type="hidden" name="gambarLama" value="<?php echo $mhs["gambar"]; ?>">
		<ul>
			<li>
				<label for="nama">Nama : </label>
				<input type="text" name="nama" id="nama" required value="<?php echo($mhs["nama"]); ?>">
			</li>
			<li>
				<label for="nim">NIM : </label>
				<input type="text" name="nim" id="nim" value="<?php echo($mhs["nim"]); ?>">
			</li>
			<li>
				<label for="email">Email : </label>
				<input type="text" name="email" id="email" value="<?php echo($mhs["email"]); ?>">
			</li>
			<li>
				<label for="jurusan">Jurusan : </label>
				<input type="text" name="jurusan" id="jurusan" value="<?php echo($mhs["jurusan"]); ?>">
			</li>
			<li>
				<label for="gambar">Gambar : </label> <br>
				<img src="img/<?php echo $mhs['gambar'] ?>" width="40"> <br>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<button type="submit" name="submit">Ubah Data!</button>
			</li>


		</ul>


	</form>

</body>
</html>