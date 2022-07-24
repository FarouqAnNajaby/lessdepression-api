<?php
require("koneksi.php");

$perintah = "SELECT tb_transaksi.id, tb_transaksi.id_dokter, tb_transaksi.id_pengguna, tb_transaksi.bukti_transfer, tb_transaksi.lokasi_bukti_transfer, tb_transaksi.nominal_transfer, tb_transaksi.atas_nama_atm, tb_transaksi.status
, tb_dokter.nama_lengkap, tb_dokter.bidang_keahlian, tb_dokter.foto, tb_dokter.lokasi_foto, tb_dokter.email AS email_dokter,  tb_pengguna.nama, tb_pengguna.foto, tb_pengguna.lokasi_foto, tb_pengguna.email AS email_pasien
FROM tb_transaksi JOIN tb_dokter ON tb_transaksi.id_dokter = tb_dokter.id
JOIN tb_pengguna ON tb_transaksi.id_pengguna = tb_pengguna.id WHERE status = 'proses'";
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
        $F["nominal_transfer"] = $ambil->nominal_transfer;
        $F["nama_dokter"] = $ambil->nama_lengkap;
        $F["nama_pasien"] = $ambil->nama;
        $F["email_dokter"] = $ambil->email_dokter;
        $F["email_pasien"] = $ambil->email_pasien;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);