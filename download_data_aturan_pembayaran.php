<?php

	require("koneksi.php");

	$id = $_POST["id"];

	$sqlQuery = "SELECT * FROM tb_aturan_pembayaran WHERE id = '$id'";

	$result = mysqli_query($konek, $sqlQuery);

	$dataaturanpembayaran = array();

	while($row = mysqli_fetch_array($result)){

		$dataaturanpembayaran["id"] = $row[0];
		$dataaturanpembayaran["nama_bank"] = $row[1];
		$dataaturanpembayaran["atas_nama_rekening"] = $row[2];
		$dataaturanpembayaran["rekening"] = $row[3];
		$dataaturanpembayaran["potongan_konsultasi"] = $row[4];

	}

	mysqli_close($konek);

	print(json_encode($dataaturanpembayaran));

?>