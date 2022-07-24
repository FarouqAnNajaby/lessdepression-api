<?php

	require("koneksi.php");

	$id = $_POST["id_dokter"];

	$sqlQuery = "SELECT * FROM tb_dokter WHERE id = '$id'";

	$result = mysqli_query($konek, $sqlQuery);

	$dataprofil = array();

	while($row = mysqli_fetch_array($result)){

		$dataprofil["id"] = $row[0];
		$dataprofil["nip"] = $row[1];
		$dataprofil["nama_lengkap"] = $row[2];
		$dataprofil["kelamin"] = $row[3];
		$dataprofil["bidang_keahlian"] = $row[4];
		$dataprofil["gelar_sarjana"] = $row[5];
		$dataprofil["kantor"] = $row[6];
		$dataprofil["kerja_praktek"] = $row[7];
		$dataprofil["email"] = $row[8];
		// $dataprofil["foto"] = $row[10];

		$imageLocation = $row[11];

		$imageFile = file_get_contents($imageLocation);

		$dataprofil["foto"] = base64_encode($imageFile);

	}

	mysqli_close($konek);

	print(json_encode($dataprofil));

?>