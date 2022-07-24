<?php
require("koneksi.php");

$id_dokter = $_POST["id_dokter"];
$id_pasien = $_POST["id_pasien"];

// $id_dokter = 14;
// $id_pasien = 4;

$perintah = "SELECT 
tb_messages.id,
tb_messages.id_dokter,
tb_messages.id_pengguna, 
tb_messages.message, 
tb_messages.id_send, 
tb_messages.date,
tb_pengguna.nama, 
tb_pengguna.email AS email_pasien,
tb_pengguna.foto AS foto_pasien, 
tb_pengguna.lokasi_foto AS lokasi_foto_pasien,
tb_dokter.nama_lengkap, 
tb_dokter.email AS email_dokter, 
tb_dokter.foto AS foto_dokter, 
tb_dokter.lokasi_foto AS lokasi_foto_dokter
FROM tb_messages
JOIN tb_pengguna ON tb_messages.id_pengguna = tb_pengguna.id
JOIN tb_dokter ON tb_messages.id_dokter = tb_dokter.id 
WHERE tb_messages.id_dokter = '$id_dokter'
AND tb_messages.id_pengguna = '$id_pasien'
ORDER BY tb_messages.id ASC";

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
        $F["message"] = $ambil->message;
        $F["id_send"] = $ambil->id_send;
        $F["date"] = $ambil->date;
        $F["tanggal"] = date('d-m-Y', strtotime($ambil->date));
        $F["waktu"] = date('H:i', strtotime($ambil->date));
        $F["nama_pasien"] = $ambil->nama;
        $F["nama_dokter"] = $ambil->nama_lengkap;
        $F["email_pasien"] = $ambil->email_pasien;
        $F["email_dokter"] = $ambil->email_dokter;
        $imageFile_pasien = file_get_contents($ambil->lokasi_foto_pasien);
        $F["foto_pasien"] = base64_encode($imageFile_pasien);
        $imageFile_dokter = file_get_contents($ambil->lokasi_foto_dokter);
        $F["foto_dokter"] = base64_encode($imageFile_dokter);
        
        // $F["message"] = $ambil->message;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);

?>