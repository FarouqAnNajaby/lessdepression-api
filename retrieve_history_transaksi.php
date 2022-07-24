<?php
require("koneksi.php");

$id_pengguna = 0;
$email = $_POST["email"];
// $email = "dwikumarawidyatna123@gmail.com";


$perintah_satu = "SELECT id FROM tb_pengguna WHERE email ='$email'";
$eksekusi_satu = mysqli_query($konek, $perintah_satu);

while ($row = $eksekusi_satu->fetch_assoc()) {
    $id_pengguna = $row['id'];
}

$perintah = "SELECT 
tb_transaksi.id, 
tb_transaksi.id_dokter, 
tb_transaksi.id_pengguna, 
tb_transaksi.bukti_transfer, 
tb_transaksi.lokasi_bukti_transfer, 
tb_transaksi.nominal_transfer, 
tb_transaksi.atas_nama_atm, 
tb_transaksi.status, 
tb_dokter.nama_lengkap, 
tb_dokter.bidang_keahlian, 
tb_dokter.foto, 
tb_dokter.lokasi_foto,
tb_rating_dokter.rating
FROM tb_transaksi 
LEFT JOIN tb_rating_dokter ON tb_transaksi.id = tb_rating_dokter.id_transaksi
JOIN tb_dokter ON tb_transaksi.id_dokter = tb_dokter.id 
WHERE tb_transaksi.id_pengguna = '$id_pengguna'";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id"] = $ambil->id;
        $F["id_dokter"] = $ambil->id_dokter;
        $F["id_pengguna"] = $ambil->id_pengguna;
        $F["bukti_transfer"] = $ambil->bukti_transfer;
        $F["lokasi_bukti_transfer"] = $ambil->lokasi_bukti_transfer;
        $F["nominal_transfer"] = $ambil->nominal_transfer;
        $F["atas_nama_atm"] = $ambil->atas_nama_atm;
        $F["status"] = $ambil->status;
        $F["nama_lengkap"] = $ambil->nama_lengkap;
        $F["bidang_keahlian"] = $ambil->bidang_keahlian;
        if ($ambil->rating == null){
            $F["rating"] = 0;
        }else{
            $F["rating"] = $ambil->rating;
        }
        
        $imageFile = file_get_contents($ambil->lokasi_foto);
		$F["foto"] = base64_encode($imageFile);

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);