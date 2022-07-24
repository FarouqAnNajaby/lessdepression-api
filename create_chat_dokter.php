<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$id_dokter = $_POST["id_dokter"];
	$id_pasien = $_POST["id_pasien"];
	$message = $_POST["message"];
	
	date_default_timezone_set('Asia/Jakarta');
	$tanggal = date('Y-m-d H:i:s');

	$perintah = "INSERT INTO tb_messages(id_pengguna, id_dokter, message, id_send, date) 
	VALUES ('$id_pasien', '$id_dokter', '$message', '$id_dokter', '$tanggal')";
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
