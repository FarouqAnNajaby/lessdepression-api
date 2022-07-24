<?php
require("koneksi.php");

$id_pasien = 0;
$email = $_POST["email"];
// $email = "dwikumarawidyatna123@gmail.com";

$perintah_satu = "SELECT id FROM tb_pengguna WHERE email ='$email'";
$eksekusi_satu = mysqli_query($konek, $perintah_satu);

while ($row = $eksekusi_satu->fetch_assoc()) {
    $id_pasien = $row['id'];
}

// echo($id_dokter);

$perintah = "SELECT 
tb_transaksi.id,
tb_transaksi.id_dokter,
tb_transaksi.id_pengguna, 
tb_dokter.nama_lengkap, 
tb_dokter.foto, 
tb_dokter.lokasi_foto,
(   SELECT message 
    FROM tb_messages 
    WHERE id_pengguna = '$id_pasien' AND id_dokter = tb_transaksi.id_dokter
    ORDER BY id DESC LIMIT 1
) AS message
FROM tb_transaksi
JOIN tb_dokter ON tb_transaksi.id_dokter = tb_dokter.id 
WHERE tb_transaksi.id_pengguna = '$id_pasien'
AND tb_transaksi.status = 'ongoing'";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id"] = $ambil->id;
        $F["id_dokter"] = $ambil->id_dokter;
        $F["id_pasien"] = $ambil->id_pengguna;
        $F["id"] = $ambil->id;
        $F["nama_dokter"] = $ambil->nama_lengkap;
        $imageFile_dokter = file_get_contents($ambil->lokasi_foto);
        $F["foto_dokter"] = base64_encode($imageFile_dokter);
        $F["message"] = $ambil->message;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);

?>