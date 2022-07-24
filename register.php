<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$email = $_POST['email'];
    $nama = $_POST['nama'];
    $sandi = $_POST['sandi'];
	$kelamin = $_POST['kelamin'];
	$foto = $_POST['foto'];

	$imageLocation = "pengguna/" . generateRandom(20, true) . ".jpg";

    $perintah = "INSERT INTO tb_pengguna(email, nama, sandi, kelamin, foto, lokasi_foto) VALUES ('$email', '$nama', '$sandi', '$kelamin', '$email', '$imageLocation')";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0) {
		file_put_contents($imageLocation, base64_decode($foto));
        $response["kode"] = 1;
        $response["pesan"] = "Simpan Data Berhasil";
    } else{
        $response["kode"] = 0;
        $response["pesan"] = "Gagal Menyimpan Data";
    }
} else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);