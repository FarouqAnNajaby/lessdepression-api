<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST["email"];
    $sandi = $_POST["sandi"];

    $perintah = "SELECT * FROM tb_pengguna WHERE email = '$email' and sandi = '$sandi'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $row = mysqli_fetch_assoc($eksekusi);
        $email = $row['email']; 
        if($email == "adminDepresi"){
            $response["kode"] = 1;
            $response["pesan"] = "Login Berhasil";
        }else{
            $response["kode"] = 2;
            $response["pesan"] = "Login Berhasil";
        }
        
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