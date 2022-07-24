<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$id_pengguna = $_POST["id_pengguna"];
	$id_dokter = $_POST["id_dokter"];
	$rating = $_POST["rating"];
	$id_transaksi = $_POST["id_transaksi"];

	$perintah = "INSERT INTO tb_rating_dokter(id_pengguna, id_dokter, id_transaksi, rating) VALUES ('$id_pengguna', '$id_dokter', '$id_transaksi', '$rating')";
	$eksekusi = mysqli_query($konek, $perintah);
	$cek = mysqli_affected_rows($konek);

	if ($cek > 0) {
		$response["kode"] = 1;
		$response["pesan"] = "Simpan Data Berhasil";
	} else {
		$response["kode"] = 0;
		$response["pesan"] = "Gagal Menyimpan Data";
	}
} else {
	$response["kode"] = 0;
	$response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);
