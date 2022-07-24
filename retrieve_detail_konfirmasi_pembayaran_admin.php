<?php
require("koneksi.php");

$id_transaksi = $_POST["id_transaksi"];

// $id_transaksi = 4;

$perintah = "SELECT tb_transaksi.id, 
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
tb_pengguna.nama, 
tb_pengguna.foto, 
tb_pengguna.lokasi_foto,
tb_salary_dokter.nama_bank,
tb_salary_dokter.atas_nama_rekening,
tb_salary_dokter.nomer_rekening, 
tb_dokter.email,
tb_pengguna.email
FROM tb_transaksi JOIN tb_dokter ON tb_transaksi.id_dokter = tb_dokter.id
JOIN tb_pengguna ON tb_transaksi.id_pengguna = tb_pengguna.id
JOIN tb_salary_dokter ON tb_dokter.id = tb_salary_dokter.id_dokter WHERE tb_transaksi.id = $id_transaksi";

$eksekusi = mysqli_query($konek, $perintah);

	$response = array();

	while($row = mysqli_fetch_array($eksekusi)){

		$response["id"] = $row[0];
		$response["id_dokter"] = $row[1];
		$response["id_pengguna"] = $row[2];
		$imageFile_bukti_transfer = file_get_contents($row[4]);
        $response["bukti_transfer"] = base64_encode($imageFile_bukti_transfer);
		$response["nominal_transfer"] = $row[5];
		$response["atas_nama_atm"] = $row[6];
        $response["nama_dokter"] = $row[8];
		$response["nama_pasien"] = $row[12];
        $response["bidang_keahlian"] = $row[9];
		$imageFile_dokter = file_get_contents($row[11]);
        $response["foto_dokter"] = base64_encode($imageFile_dokter);
		$imageFile_pasien = file_get_contents($row[14]);
        $response["foto_pasien"] = base64_encode($imageFile_pasien);
        $response["nama_bank_dokter"] = $row[15];
        $response["atas_nama_rekening_dokter"] = $row[16];
        $response["nomer_rekening_dokter"] = $row[17];
		$response["email_dokter"] = $row[18];
		$response["email_pasien"] = $row[19];
	
	}

	mysqli_close($konek);

	print(json_encode($response));