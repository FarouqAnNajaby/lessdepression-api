<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email_admin = $_POST["email_admin"];
    $password_admin = $_POST["password_admin"];

    $perintah = "SELECT * FROM admin WHERE email_admin = '$email_admin' and password_admin = '$password_admin'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $row = mysqli_fetch_assoc($eksekusi);
        $email = $row['email_admin']; 
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