<?php
require("koneksi.php");

// $id_transaksi = $_POST["id_transaksi"];

$id_transaksi = 2;

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
tb_pengguna.lokasi_foto,
(
    SELECT status FROM tb_transaksi WHERE id_dokter = tb_transaksi_dokter.id_dokter && id_pengguna = tb_transaksi_dokter.id_pengguna
) AS status
FROM tb_transaksi_dokter 
JOIN tb_dokter ON tb_transaksi_dokter.id_dokter = tb_dokter.id
JOIN tb_pengguna ON tb_transaksi_dokter.id_pengguna = tb_pengguna.id 
WHERE tb_transaksi_dokter.id = '$id_transaksi'";

$eksekusi = mysqli_query($konek, $perintah);

	$response = array();

	while($row = mysqli_fetch_array($eksekusi)){

		$response["id"] = $row[0];
        $response["id_pengguna"] = $row[1];
        $response["id_dokter"] = $row[2];
        $response["potongan_biaya_persen"] = $row[3];
        $response["biaya_konsultasi"] = $row[4];
        $response["total_pembayaran"] = $row[5];
        $imageFile_bukti_transfer = file_get_contents($row[7]);
		$response["bukti_transfer"] = base64_encode($imageFile_bukti_transfer);
        $response["nama_pengguna"] = $row[8];
        $response["status"] = $row[11];
        $imageFile = file_get_contents($row[10]);
		$response["foto_pengguna"] = base64_encode($imageFile);

	}

	mysqli_close($konek);

	print(json_encode($response));