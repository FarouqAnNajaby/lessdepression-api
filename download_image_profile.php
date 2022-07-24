<?php

	require("koneksi.php");

	$email = $_POST['email'];

	$sqlQuery = "SELECT * FROM tb_pengguna WHERE email = '$email'";

	$result = mysqli_query($konek, $sqlQuery);

	$imageDetails = NULL;

	while($row = mysqli_fetch_array($result)){

		$imageDetails["imageSn"] = $row[1];
		$imageDetails["imageTitle"] = $row[5];

		$imageLocation = $row[6];

		$imageFile = file_get_contents($imageLocation);

		$imageDetails["encodedImage"] = base64_encode($imageFile);

	}

	mysqli_close($konek);
	print(json_encode($imageDetails));

?>