<?php

	require("koneksi.php");

	$id_pengguna = $_POST["id_pengguna"];

	$sqlQuery = "SELECT id_pengguna, COUNT(kode_history) FROM `tb_history` WHERE id_pengguna = '$id_pengguna'";

	$result = mysqli_query($konek, $sqlQuery);

	$kode_percobaan = NULL;

	while($row = mysqli_fetch_array($result)){

		$kode_percobaan["kode_percobaan"] = $row[1];
		
	}

	mysqli_close($konek);

	print(json_encode($kode_percobaan));

?>