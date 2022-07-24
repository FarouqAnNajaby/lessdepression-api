<?php

	require("koneksi.php");

	$kode_history = $_POST["kode_history"];

	$sqlQuery = "SELECT * FROM tb_history_hasil WHERE kode_history = '$kode_history'";

	$result = mysqli_query($konek, $sqlQuery);

	$datahistoryhasil = array();

	while($row = mysqli_fetch_array($result)){

		$historyhasil["indikasi"] = $row[2];
		$historyhasil["nilai_akhir"] = $row[3];

	}

	mysqli_close($konek);

	print(json_encode($historyhasil));

?>