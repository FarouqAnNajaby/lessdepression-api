<?php

	require("koneksi.php");

	$id_pengguna = $_POST["id_pengguna"];

	$sqlQuery = "SELECT * FROM tb_history WHERE id_pengguna = '$id_pengguna' ORDER BY id DESC LIMIT 1";

	$result = mysqli_query($konek, $sqlQuery);

	$datahistory = null;

	while($row = mysqli_fetch_array($result)){

		$datahistory["kode_history"] = $row[2];

	}

	mysqli_close($konek);

	print(json_encode($datahistory));

?>