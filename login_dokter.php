<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $perintah = "SELECT * FROM tb_dokter WHERE email = '$email' and sandi = '$password' and is_active = '1'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Login Berhasil";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Login Gagal";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);