<?php
require("koneksi.php");
include("fungsi.php");

date_default_timezone_set("Asia/Jakarta");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$id_dokter = $_POST['id_dokter'];
    $id_pengguna = $_POST['id_pengguna'];
    $id_transaksi = $_POST['id_transaksi'];
    $biaya_konsultasi = $_POST['biaya_konsultasi'];
    $total_pembayaran = $_POST['total_pembayaran'];
    $bukti_transfer = $_POST['bukti_transfer'];
    $status = "ongoing";
	$tanggal = date('Y-m-d H:i:s');

    $nama_foto = generateRandom(20, true);
	$imageLocation = "transfer/" . $nama_foto . ".jpg";
        
    //aturan pembayaran

    $id = 1;

	$sqlQuery = "SELECT * FROM tb_aturan_pembayaran WHERE id = '$id'";

	$result = mysqli_query($konek, $sqlQuery);

	while($row = mysqli_fetch_array($result)){

		// $dataaturanpembayaran["id"] = $row[0];
		// $dataaturanpembayaran["nama_bank"] = $row[1];
		// $dataaturanpembayaran["atas_nama_rekening"] = $row[2];
		// $dataaturanpembayaran["rekening"] = $row[3];
		$potongan_biaya_persen = $row[4];

        
        $perintah = "INSERT INTO tb_transaksi_dokter (id_dokter, id_pengguna, potongan_biaya_persen, biaya_konsultasi, total_pembayaran, bukti_transfer, lokasi_bukti_transfer, date) 
        VALUES ('$id_dokter', '$id_pengguna', '$potongan_biaya_persen', '$biaya_konsultasi', '$total_pembayaran', '$nama_foto', '$imageLocation', '$tanggal')";
        $eksekusi = mysqli_query($konek, $perintah);
        $cek = mysqli_affected_rows($konek);

        $perintah_update_status_transaksi = "UPDATE tb_transaksi SET status='$status' WHERE id = '$id_transaksi'";
        $eksekusi_update_status_transaksi = mysqli_query($konek, $perintah_update_status_transaksi);
        $cek_update = mysqli_affected_rows($konek);

        if($cek > 0 && $cek_update > 0) {
            file_put_contents($imageLocation, base64_decode($bukti_transfer));
            $response["kode"] = 1;
            $response["pesan"] = "Simpan Data Berhasil";
        } else{
            $response["kode"] = 0;
            $response["pesan"] = "Gagal Menyimpan Data";
        }

	}

} else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);