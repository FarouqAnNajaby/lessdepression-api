<?php
require("koneksi.php");

$id_pengguna = $_POST["id_pengguna"];
$kode_history = $_POST["kode_history"];

$perintah = "SELECT tb_history.tanggal,  tb_history_pilihan.kode_gejala ,
tb_history_hasil.indikasi , tb_history_hasil.nilai_akhir , tb_data_gejala.nama_gejala
FROM tb_history JOIN tb_history_pilihan ON tb_history.kode_history=tb_history_pilihan.kode_history
JOIN tb_history_hasil ON tb_history_pilihan.kode_history=tb_history_hasil.kode_history
JOIN tb_data_gejala on tb_history_pilihan.kode_gejala=tb_data_gejala.kode_gejala 
JOIN tb_pengguna on tb_history.id_pengguna = tb_pengguna.id
WHERE tb_pengguna.id = '$id_pengguna' AND tb_history.kode_history = '$kode_history'";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["kode_gejala"] = $ambil->kode_gejala;
        $F["nama_gejala"] = $ambil->nama_gejala;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);