<?php
date_default_timezone_set("Asia/Jakarta");
require("koneksi.php");
include("fungsi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$id_dokter = $_POST['id_dokter'];
    $email = $_POST['email'];
    $bukti_transfer = $_POST['bukti_transfer'];
    $nominal_transfer = $_POST['nominal_transfer'];
    $atas_nama_atm = $_POST['atas_nama_atm'];
    
    
	$tanggal = date('Y-m-d H:i:s');

    // $id_dokter = 14;
    // $email = "dwikumarawidyatna123@gmail.com";
    // $bukti_transfer = "asdfg";
    // $nominal_transfer = 100000;
    // $atas_nama_atm = "Dwi";
    
    $status = "proses";

    $nama_foto = generateRandom(20, true);
	$imageLocation = "transfer/" . $nama_foto . ".jpg";

    $perintah_pengguna = "SELECT * FROM tb_pengguna where email = '$email'";
    $eksekusi_pengguna = mysqli_query($konek, $perintah_pengguna);
    $cek_pengguna = mysqli_affected_rows($konek);
    
    while($ambil = mysqli_fetch_object($eksekusi_pengguna)){
        $id_pengguna = $ambil->id;
        
        $perintah = "INSERT INTO tb_transaksi(id_dokter, id_pengguna, bukti_transfer, lokasi_bukti_transfer, nominal_transfer, atas_nama_atm, status, date) 
        VALUES ('$id_dokter', '$id_pengguna', '$nama_foto', '$imageLocation', '$nominal_transfer', '$atas_nama_atm', '$status', '$tanggal')";
        $eksekusi = mysqli_query($konek, $perintah);
        $cek = mysqli_affected_rows($konek);

        if($cek > 0) {
            file_put_contents($imageLocation, base64_decode($bukti_transfer));
            $response["kode"] = 1;
            $response["pesan"] = "Simpan Data Berhasil";
        } else{
            $response["kode"] = 0;
            $response["pesan"] = "Gagal Menyimpan Data";
        }

    }

} else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);