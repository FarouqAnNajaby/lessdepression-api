<?php

	require("koneksi.php");

	$email = $_POST["email"];

	$sqlQuery = "SELECT * FROM tb_pengguna WHERE email = '$email'";

	$result = mysqli_query($konek, $sqlQuery);

	$response = null;

	while($row = mysqli_fetch_array($result)){

		 $response["id"] = $row[0];
		//  $response["email"] = $row[1];
		//  $response["nama"] = $row[2];
		//  $response["kelamin"] = $row[4];
		//  $response["umur"] = $row[7];
	
	}

	mysqli_close($konek);

	print(json_encode($response));
?>