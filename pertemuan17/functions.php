<?php 
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows [] = $row;
	}
	return $rows;
}



function tambah($data){
	global $conn;

	// ambil data dari tiap elemen
	$nama = htmlspecialchars($data["nama"]);
	$nim = htmlspecialchars($data["nim"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	// upload gambar
	$gambar = upload();
	if (!$gambar){
		return false;
	}

	// query insert data
	$query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function upload(){
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yg diupload
	if ($error === 4){
		echo "<script>
				alert('pilih gambar terlebih dahulu!')
			</script>";
		return false;
	}

	// cek apakah yg diupload filenya gambar?
	$ekstensiGambarValid = ['jpg','jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('yang anda upload bukan gambar!')
			</script>";
	}

	// cek apakah ukuran terlalu besar?
	if ($ukuranFile > 1000000) {
		echo "<script>
				alert('ukuran gambar terlalu besar!')
			</script>";
	}

	// generate nama gambar baru biar nama file yg sama ga ketumpuk
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	// lolos pengecekan gambar
	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
	return $namaFileBaru;


}

function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

	return mysqli_affected_rows($conn);
}

function ubah($data){
	global $conn;

	// ambil data dari tiap elemen
	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$nim = htmlspecialchars($data["nim"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	$gambarLama = $data["gambarLama"];

	// cek apakah user pilih gambar baru atau tidak
	if ($_FILES['gambar']['error'] === 4) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}
	

	// query insert data
	$query = "UPDATE mahasiswa SET 
		nama = '$nama', 
		nim = '$nim', 
		email = '$email', 
		jurusan = '$jurusan', 
		gambar = '$gambar' 
		WHERE id = $id";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function cari($keyword){
	$query = "SELECT * FROM mahasiswa 
				WHERE
	 		nama LIKE '%$keyword%' OR
	 		nim LIKE '%$keyword%' OR
	 		email LIKE '%$keyword%' OR
	 		jurusan LIKE '%$keyword%'
	 		";
	return query($query);
}

function registrasi($data){
	global $conn;

	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// pengecekan username udah ada atau belom
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
				alert('username sudah terdaftar!')
		</script>";
		return false;
	} 

	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!')
		</script>";
		return false;
	} 

	// enskripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan user baru ke DB
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

	return mysqli_affected_rows($conn);

	

}

?>