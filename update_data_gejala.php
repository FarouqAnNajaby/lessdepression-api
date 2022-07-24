<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $kode_gejala = $_POST["kode_gejala"];
    $nama_gejala = $_POST["nama_gejala"];
    $bobot_gejala = $_POST["bobot_gejala"];
    
    $perintah = "UPDATE tb_data_gejala SET nama_gejala='$nama_gejala', bobot_gejala='$bobot_gejala' WHERE kode_gejala='$kode_gejala'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Data Berhasil Diupdate";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Gagal Mengupdate Data";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);