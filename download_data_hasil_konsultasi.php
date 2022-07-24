<?php

	require("koneksi.php");

	$kode_history = $_POST["kode_history"];

	$sqlQuery = "SELECT * FROM tb_history_hasil WHERE kode_history = '$kode_history'";

	$result = mysqli_query($konek, $sqlQuery);

	$data = array();

	while($row = mysqli_fetch_array($result)){

		$data["id_dokter"] = $row["id_dokter"];
		$data["hasil_konsultasi"] = $row["hasil_konsultasi"];
		$data["link_youtube"] = $row["link_youtube"];

		$id_dokter = $data["id_dokter"];

		if( $id_dokter != 0){

			$sqlQueryDokter = "SELECT * FROM tb_dokter WHERE id = '$id_dokter'";

			$resultDokter = mysqli_query($konek, $sqlQueryDokter);

				while($rowDokter = mysqli_fetch_array($resultDokter)){

					$data["nama_dokter"] = $rowDokter["nama_lengkap"];
				
				}

		}

	}

	mysqli_close($konek);

	print(json_encode($data));

?>