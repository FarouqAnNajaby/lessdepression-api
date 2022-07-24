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

// $perintah = "SELECT * FROM tb_transaksi_dokter 
// JOIN tb_dokter ON tb_transaksi_dokter.id_dokter = tb_dokter.id 
// WHERE tb_transaksi_dokter.id_dokter = '14'";

$perintah = "SELECT 
tb_transaksi_dokter.id,  
tb_transaksi_dokter.id_pengguna,
tb_transaksi_dokter.id_dokter, 
tb_transaksi_dokter.potongan_biaya_persen, 
tb_transaksi_dokter.biaya_konsultasi, 
tb_transaksi_dokter.total_pembayaran, 
tb_transaksi_dokter.bukti_transfer, 
tb_transaksi_dokter.lokasi_bukti_transfer, 
tb_pengguna.nama, 
tb_pengguna.foto, 
tb_pengguna.lokasi_foto 
FROM tb_transaksi_dokter 
JOIN tb_dokter ON tb_transaksi_dokter.id_dokter = tb_dokter.id
JOIN tb_pengguna ON tb_transaksi_dokter.id_pengguna = tb_pengguna.id 
WHERE tb_transaksi_dokter.id_dokter = $id_dokter";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id"] = $ambil->id;
        $F["id_pengguna"] = $ambil->id_pengguna;
        $F["id_dokter"] = $ambil->id_dokter;
        $F["potongan_biaya_persen"] = $ambil->potongan_biaya_persen;
        $F["biaya_konsultasi"] = $ambil->biaya_konsultasi;
        $F["total_pembayaran"] = $ambil->total_pembayaran;
        $imageFile_bukti_transfer = file_get_contents($ambil->lokasi_bukti_transfer);
		$F["bukti_transfer"] = base64_encode($imageFile_bukti_transfer);
        $F["nama_pengguna"] = $ambil->nama;
        $imageFile = file_get_contents($ambil->lokasi_foto);
		$F["foto_pengguna"] = base64_encode($imageFile);

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);