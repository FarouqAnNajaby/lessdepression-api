<?php
require("koneksi.php");

$id_dokter = 0;

$email = $_POST["email"];

$perintah_satu = "SELECT id FROM tb_dokter WHERE email ='$email'";
$eksekusi_satu = mysqli_query($konek, $perintah_satu);

while ($row = $eksekusi_satu->fetch_assoc()) {
    $id_dokter = $row['id'];
}

$perintah = "SELECT tb_rating_dokter.id_pengguna, tb_rating_dokter.id_dokter,tb_rating_dokter.rating,tb_pengguna.nama
FROM tb_rating_dokter INNER JOIN tb_pengguna on tb_rating_dokter.id_pengguna = tb_pengguna.id
WHERE tb_rating_dokter.id_dokter = '$id_dokter'";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id_pengguna"] = $ambil->id_pengguna;
        $F["id_dokter"] = $ambil->id_dokter;
        $F["rating"] = $ambil->rating;
        $F["nama"] = $ambil->nama;
        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);
