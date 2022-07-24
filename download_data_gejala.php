<?php

	require("koneksi.php");

	$kode_gejala = $_POST["kode_gejala"];

	$sqlQuery = "SELECT tb_data_gejala.id, tb_data_gejala.kode_gejala, tb_data_gejala.nama_gejala, tb_data_gejala.bobot_gejala, tb_tingkatan_gejala.depresi_ringan, tb_tingkatan_gejala.depresi_sedang, tb_tingkatan_gejala.depresi_berat from tb_tingkatan_gejala INNER JOIN tb_data_gejala ON tb_tingkatan_gejala.kode_gejala = tb_data_gejala.kode_gejala WHERE tb_data_gejala.kode_gejala = '$kode_gejala'";

	$result = mysqli_query($konek, $sqlQuery);

	$response = array();

	while($row = mysqli_fetch_array($result)){

		$response["nama_gejala"] = $row[2];
		$response["bobot_gejala"] = $row[3];
		$response["depresi_ringan"] = $row[4];
		$response["depresi_sedang"] = $row[5];
		$response["depresi_berat"] = $row[6];
	
	}

	mysqli_close($konek);

	print(json_encode($response));
?>