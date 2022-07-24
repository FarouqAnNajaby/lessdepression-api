<?php
require("koneksi.php");
include("fungsi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$foto = $_POST['foto'];
    $nip = $_POST['nip'];
    $nama_lengkap = $_POST['nama_lengkap'];
  	$kelamin = $_POST['kelamin'];
	$bidang_keahlian = $_POST['bidang_keahlian'];
    $gelar_sarjana = $_POST['gelar_sarjana'];
  	$kantor = $_POST['kantor'];
	$kerja_praktek = $_POST['kerja_praktek'];
	$email = $_POST['email'];
    $sandi = $_POST['sandi'];
    $is_active = $_POST['is_active'];

    $nama_foto = generateRandom(20, true);
	$imageLocation = "dokter/" . $nama_foto . ".jpg";
    

    $perintah = "INSERT INTO tb_dokter(nip, nama_lengkap, kelamin, bidang_keahlian, gelar_sarjana, kantor, kerja_praktek, email, sandi, foto, lokasi_foto, is_active) 
    VALUES ('$nip', '$nama_lengkap', '$kelamin', '$bidang_keahlian', '$gelar_sarjana', '$kantor', '$kerja_praktek', '$email', '$sandi', '$nama_foto', '$imageLocation', '$is_active')";
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