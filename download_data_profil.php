<?php

	require("koneksi.php");

	$email = $_POST["email"];

	$sqlQuery = "SELECT * FROM tb_pengguna WHERE email = '$email'";

	$result = mysqli_query($konek, $sqlQuery);

	$dataprofil = array();

	while($row = mysqli_fetch_array($result)){

		$dataprofil["id_pengguna"] = $row[0];
		$dataprofil["email_pengguna"] = $row[1];
		$dataprofil["nama_pengguna"] = $row[2];
		$dataprofil["jk_pengguna"] = $row[4];

	}

	mysqli_close($konek);

	print(json_encode($dataprofil));

?>