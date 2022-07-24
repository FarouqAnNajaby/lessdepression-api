<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$email = $_POST["email"];
	$kode_history = $_POST["kode_history"];
	$hasil_konsultasi = $_POST["hasil_konsultasi"];
	$id_transaksi = $_POST["id_transaksi"];
	$link_youtube = $_POST["link_youtube"];
	$id_dokter = 0;

	$perintah_pengguna = "SELECT * FROM tb_dokter where email = '$email'";
    $eksekusi_pengguna = mysqli_query($konek, $perintah_pengguna);
    $cek_pengguna = mysqli_affected_rows($konek);
    
    while($ambil = mysqli_fetch_object($eksekusi_pengguna)){
        $id_dokter = $ambil->id;
	
		if($link_youtube == ""){
			$perintah = "UPDATE tb_history_hasil SET id_dokter='$id_dokter', hasil_konsultasi='$hasil_konsultasi' WHERE kode_history='$kode_history'";
			$eksekusi = mysqli_query($konek, $perintah);
			$cek = mysqli_affected_rows($konek);
	
		}else{
			$perintah = "UPDATE tb_history_hasil SET id_dokter='$id_dokter', hasil_konsultasi='$hasil_konsultasi', link_youtube='$link_youtube' WHERE kode_history='$kode_history'";
			$eksekusi = mysqli_query($konek, $perintah);
			$cek = mysqli_affected_rows($konek);

		}

		
		if ($cek > 0) {

			$perintah_update = "UPDATE tb_transaksi SET status = 'completed' WHERE id='$id_transaksi'";
    		$eksekusi_update = mysqli_query($konek, $perintah_update);

			$response["kode"] = 1;
			$response["pesan"] = "Simpan Data Berhasil";
		} else {
			$response["kode"] = 0;
			$response["pesan"] = "Gagal Menyimpan Data";
		}

	}

} else {
	$response["kode"] = 0;
	$response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);
