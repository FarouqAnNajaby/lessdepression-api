<?php
require("koneksi.php");

$id_dokter = 0;
$email = $_POST["email"];
// $email = "agunggelarpambudi@gmail.com";

$perintah_satu = "SELECT id FROM tb_dokter WHERE email ='$email'";
$eksekusi_satu = mysqli_query($konek, $perintah_satu);

while ($row = $eksekusi_satu->fetch_assoc()) {
    $id_dokter = $row['id'];
}

// echo($id_dokter);

$perintah = "SELECT 
tb_transaksi.id,
tb_transaksi.id_dokter,
tb_transaksi.id_pengguna,
tb_pengguna.email, 
tb_pengguna.nama, 
tb_pengguna.foto, 
tb_pengguna.lokasi_foto,
(   SELECT message 
    FROM tb_messages 
    WHERE id_dokter = '$id_dokter' AND id_pengguna = tb_transaksi.id_pengguna
    ORDER BY id DESC LIMIT 1
) AS message
FROM tb_transaksi
JOIN tb_pengguna ON tb_transaksi.id_pengguna = tb_pengguna.id 
WHERE tb_transaksi.id_dokter = '$id_dokter'
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
        $F["id_passien"] = $ambil->id_pengguna;
        $F["id"] = $ambil->id;
        $F["email_pasien"] = $ambil->email;
        $F["nama_pasien"] = $ambil->nama;
        $imageFile_pasien = file_get_contents($ambil->lokasi_foto);
        $F["foto_passien"] = base64_encode($imageFile_pasien);
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