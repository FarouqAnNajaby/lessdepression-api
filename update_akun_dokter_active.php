<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST["email"];

    $perintah = "UPDATE tb_dokter SET is_active='1' WHERE email = '$email'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Data akun berhasil diterima";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Data akun gagal diterima";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);