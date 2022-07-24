<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $kode_gejala = $_POST["kode_gejala"];
    $depresi_ringan = $_POST["depresi_ringan"];
    $depresi_sedang = $_POST["depresi_sedang"];
    $depresi_berat = $_POST["depresi_berat"];

    $perintah = "UPDATE tb_tingkatan_gejala SET depresi_ringan='$depresi_ringan', depresi_sedang='$depresi_sedang', depresi_berat='$depresi_berat' WHERE kode_gejala='$kode_gejala'";
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