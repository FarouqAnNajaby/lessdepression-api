<?php
require("koneksi.php");
$perintah = "SELECT tb_data_gejala.id, tb_data_gejala.kode_gejala, tb_data_gejala.nama_gejala, tb_data_gejala.bobot_gejala, tb_tingkatan_gejala.depresi_ringan, tb_tingkatan_gejala.depresi_sedang, tb_tingkatan_gejala.depresi_berat from tb_tingkatan_gejala INNER JOIN tb_data_gejala ON tb_tingkatan_gejala.kode_gejala = tb_data_gejala.kode_gejala";
$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["kode_gejala"] = $ambil->kode_gejala;
        $F["nama_gejala"] = $ambil->nama_gejala;
        $F["bobot_gejala"] = $ambil->bobot_gejala;
        $F["depresi_ringan"] = $ambil->depresi_ringan;
        $F["depresi_sedang"] = $ambil->depresi_sedang;
        $F["depresi_berat"] = $ambil->depresi_berat;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);