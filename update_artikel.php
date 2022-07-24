<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $kode_artikel = $_POST["kode_artikel"];
    $judul_artikel = $_POST["judul_artikel"];
    $isi_artikel = $_POST["isi_artikel"];
    $tingkat_depresi = $_POST["tingkat_depresi"];

    $perintah = "UPDATE tb_artikel SET judul_artikel='$judul_artikel', isi_artikel='$isi_artikel', tingkat_depresi='$tingkat_depresi' WHERE kode_artikel='$kode_artikel'";
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