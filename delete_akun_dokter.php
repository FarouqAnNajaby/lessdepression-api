<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST["email"];

    $lokasi_foto = "";

    $query_lokasi_foto = "SELECT lokasi_foto FROM tb_dokter WHERE email = '$email'";
    $eksekusi_lokasi_foto = mysqli_query($konek, $query_lokasi_foto);
    $lokasi_foto = mysqli_fetch_object($eksekusi_lokasi_foto)->lokasi_foto;
    
    unlink($lokasi_foto);

    $perintah = "DELETE FROM tb_dokter WHERE email = '$email'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Data akun berhasil ditolak";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Data akun gagal ditolak";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);