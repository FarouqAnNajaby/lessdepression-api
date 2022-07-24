<?php

	require("koneksi.php");

	// $id = $_POST["id"];
	$id = 0;

	$email = $_POST["email"];

	// $email = "agunggelarpambudi@gmail.com";

	$sqlQueryId = "SELECT * FROM tb_dokter WHERE email = '$email'";

	$resultId = mysqli_query($konek, $sqlQueryId);

	while($rowId = mysqli_fetch_array($resultId)){

		$id = $rowId[0];
		
		$sqlQuery = "SELECT COUNT(id_dokter) AS total_pasien,
				(
					SELECT COUNT(id_dokter) FROM tb_transaksi WHERE id_dokter = '$id' AND status = 'ongoing'
				) AS ongoing,
				(
					SELECT COUNT(id_dokter) FROM tb_transaksi WHERE id_dokter = '$id' AND status = 'completed'
				) AS completed FROM tb_transaksi WHERE id_dokter = '$id'";

		$result = mysqli_query($konek, $sqlQuery);

		$datastatus = array();

		while($row = mysqli_fetch_array($result)){

			$datastatus["total_pasien"] = $row["total_pasien"];
			$datastatus["status_ongoing"] = $row["ongoing"];
			$datastatus["status_completed"] = $row["completed"];
			
		}



	}

	mysqli_close($konek);

	print(json_encode($datastatus));

?>