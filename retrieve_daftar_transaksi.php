<?php
require("koneksi.php");

    date_default_timezone_set('Asia/Jakarta');
	$bulan = date('m');

$perintah = "SELECT tb_transaksi_dokter.id
                tb_transaksi_dokter.biaya_konsultasi - tb_transaksi_dokter.total_pembayaran AS total_biaya_admin,
                tb_transaksi_dokter.id_dokter, 
                tb_transaksi_dokter.id_pengguna,
                tb_transaksi_dokter.date,
                tb_dokter.nama_lengkap,
                tb_pengguna.nama
                FROM tb_transaksi_dokter JOIN tb_dokter ON tb_transaksi_dokter.id_dokter = tb_dokter.id
                JOIN tb_pengguna ON tb_transaksi_dokter.id_pengguna = tb_pengguna.id
                WHERE MONTH(tb_transaksi_dokter.date) = '$bulan'
                ORDER BY tb_transaksi_dokter.id DESC";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id_transaksi"] = $ambil->id;
        $F["total_pemasukan"] = $ambil->total_biaya_admin;
        $F["id_dokter"] = $ambil->id_dokter;
        $F["id_pengguna"] = $ambil->id_pengguna;
        $F["date"] = $ambil->date;
        $F["nama_dokter"] = $ambil->nama_lengkap;
        $F["nama_pengguna"] = $ambil->nama;
        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);
