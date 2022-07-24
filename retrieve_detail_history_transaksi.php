<?php
require("koneksi.php");

$id_transaksi = $_POST["id_transaksi"];

// $id_transaksi = 4;

$perintah = "SELECT tb_transaksi.id, tb_transaksi.id_dokter, tb_transaksi.id_pengguna, tb_transaksi.bukti_transfer, tb_transaksi.lokasi_bukti_transfer, tb_transaksi.nominal_transfer, tb_transaksi.atas_nama_atm, tb_transaksi.status
, tb_dokter.nama_lengkap, tb_dokter.bidang_keahlian, tb_dokter.foto, tb_dokter.lokasi_foto FROM tb_transaksi JOIN tb_dokter ON tb_transaksi.id_dokter = tb_dokter.id WHERE tb_transaksi.id = '$id_transaksi'";
$eksekusi = mysqli_query($konek, $perintah);

	$response = array();

	while($row = mysqli_fetch_array($eksekusi)){

		$response["id"] = $row[0];
		$response["id_dokter"] = $row[1];
		$response["id_pengguna"] = $row[2];
		$imageFile_bukti_transfer = file_get_contents($row[4]);
        $response["bukti_transfer"] = base64_encode($imageFile_bukti_transfer);
		$response["nominal_transfer"] = $row[5];
        $response["nama_lengkap"] = $row[8];
        $response["bidang_keahlian"] = $row[9];
		$imageFile_dokter = file_get_contents($row[11]);
        $response["foto"] = base64_encode($imageFile_dokter);
        $response["status"] = $row[7];

        // $F["atas_nama_atm"] = $ambil->atas_nama_atm;
        // $F["status"] = $ambil->status;
        // $F["nama_lengkap"] = $ambil->nama_lengkap;
        // $F["bidang_keahlian"] = $ambil->bidang_keahlian;
        // $imageFile = file_get_contents($ambil->lokasi_foto);
		// $F["foto"] = base64_encode($imageFile);
	
	}

	mysqli_close($konek);

	print(json_encode($response));