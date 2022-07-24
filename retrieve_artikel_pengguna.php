<?php
require("koneksi.php");

$tingkat_depresi = $_POST["tingkat_depresi"];

$perintah = "SELECT * FROM tb_artikel WHERE tingkat_depresi = '$tingkat_depresi'";
$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["kode_artikel"] = $ambil->kode_artikel;
        $F["judul_artikel"] = $ambil->judul_artikel;
        $F["isi_artikel"] = $ambil->isi_artikel;
        $F["tingkat_depresi"] = $ambil->tingkat_depresi;
        $F["gambar_artikel"] = $ambil->gambar_artikel;
        $F["lokasi_gambar"] = $ambil->lokasi_gambar;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);