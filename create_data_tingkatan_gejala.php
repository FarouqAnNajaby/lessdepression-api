<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $kode_gejala = $_POST["kode_gejala"];
    $depresi_ringan = $_POST["depresi_ringan"];
    $depresi_sedang = $_POST["depresi_sedang"];
    $depresi_berat = $_POST["depresi_berat"];
    
    $perintah = "INSERT INTO tb_tingkatan_gejala(kode_gejala, depresi_ringan, depresi_sedang, depresi_berat) VALUES ('$kode_gejala', '$depresi_ringan', '$depresi_sedang', '$depresi_berat')";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Simpan Data Berhasil";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Gagal Menyimpan Data";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);