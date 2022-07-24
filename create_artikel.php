<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$kode_artikel = $_POST["kode_artikel"];
	$judul_artikel = $_POST["judul_artikel"];
	$isi_artikel = $_POST["isi_artikel"];
	$tingkat_depresi = $_POST["tingkat_depresi"];
	$gambar_artikel = $_POST["gambar_artikel"];

	$imageLocation = "artikel/" . generateRandom(20, true) . ".jpg";

	$perintah = "INSERT INTO tb_artikel(kode_artikel, judul_artikel, isi_artikel, tingkat_depresi, gambar_artikel, lokasi_gambar) VALUES ('$kode_artikel', '$judul_artikel', '$isi_artikel', '$tingkat_depresi', '$kode_artikel', '$imageLocation')";
	$eksekusi = mysqli_query($konek, $perintah);
	$cek = mysqli_affected_rows($konek);

	if ($cek > 0) {
		file_put_contents($imageLocation, base64_decode($gambar_artikel));
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
