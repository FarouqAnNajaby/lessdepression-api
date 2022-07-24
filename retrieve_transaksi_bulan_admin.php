<?php
require("koneksi.php");

    date_default_timezone_set('Asia/Jakarta');
	$bulan = date('m');

	if($bulan == 1){
		$nama_bulan = "Januari";
	}else if($bulan == 2){
		$nama_bulan = "Februari";
	}else if($bulan == 3){
		$nama_bulan = "Maret";
	}else if($bulan == 4){
		$nama_bulan = "April";
	}else if($bulan == 5){
		$nama_bulan = "Mei";
	}else if($bulan == 6){
		$nama_bulan = "Juni";
	}else if($bulan == 7){
		$nama_bulan = "Juli";
	}else if($bulan == 8){
		$nama_bulan = "Agustus";
	}else if($bulan == 9){
		$nama_bulan = "September";
	}else if($bulan == 10){
		$nama_bulan = "Oktober";
	}else if($bulan == 11){
		$nama_bulan = "November";
	}else if($bulan == 12){
		$nama_bulan = "Desember";
	}

    $perintah = "SELECT tb_transaksi_dokter.id,
                    tb_transaksi_dokter.biaya_konsultasi - tb_transaksi_dokter.total_pembayaran AS total_pemasukan, 
                    tb_transaksi_dokter.potongan_biaya_persen,
                    tb_transaksi_dokter.biaya_konsultasi,
                    tb_transaksi_dokter.total_pembayaran,
                    tb_dokter.nama_lengkap,
                    tb_pengguna.nama
                    FROM tb_transaksi_dokter
                    JOIN tb_dokter ON tb_transaksi_dokter.id_dokter = tb_dokter.id
                    JOIN tb_pengguna ON tb_transaksi_dokter.id_pengguna = tb_pengguna.id 
                    WHERE MONTH(tb_transaksi_dokter.date) = $bulan
                    ORDER BY tb_transaksi_dokter.id DESC";

    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id_transaksi"] = $ambil->id;
        $F["total_pemasukan"] = $ambil->total_pemasukan;
        $F["potongan_biaya_persen"] = $ambil->potongan_biaya_persen;
        $F["biaya_konsultasi"] = $ambil->biaya_konsultasi;
        $F["total_pembayaran"] = $ambil->total_pembayaran;
        $F["nama_dokter"] = $ambil->nama_lengkap;
        $F["nama_pasien"] = $ambil->nama;

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);