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
		
		$sqlQuery = "SELECT SUM(biaya_konsultasi - total_pembayaran) AS total_pemasukan,
					(
						SELECT COUNT(id) FROM tb_dokter WHERE is_active = 1
					) AS dokter,
					(
						SELECT COUNT(id) FROM tb_transaksi WHERE status = 'proses'
					) AS verifikasi_transaksi,
					(
						SELECT COUNT(id) FROM tb_transaksi 
					) AS transaksi FROM tb_transaksi_dokter WHERE MONTH(date) = $bulan";

		$result = mysqli_query($konek, $sqlQuery);

		$datastatus = array();

		while($row = mysqli_fetch_array($result)){

			$datastatus["total_pemasukan"] = $row["total_pemasukan"];
			$datastatus["total_dokter"] = $row["dokter"];
			$datastatus["total_konfirmasi_pembayaran"] = $row["verifikasi_transaksi"];
			$datastatus["total_transaksi"] = $row["transaksi"];
        	$datastatus["bulan"] = $nama_bulan;
			
		}

	mysqli_close($konek);

	print(json_encode($datastatus));

?>