<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $id = 1;
    $nama_bank = $_POST["nama_bank"];
    $atas_nama_rekening = $_POST["atas_nama_rekening"];
    $rekening = $_POST["rekening"];
    $potongan_konsultasi = $_POST["potongan_konsultasi"];

    $perintah = "UPDATE tb_aturan_pembayaran SET nama_bank='$nama_bank', atas_nama_rekening='$atas_nama_rekening', rekening='$rekening', potongan_konsultasi='$potongan_konsultasi' WHERE id='$id'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Data Berhasil Diupdate";
    }
    else{
        $response["kode"] = 0;
        $response["pesan"] = "Gagal Mengupdate Data";
    }
}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);