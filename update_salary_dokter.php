<?php
require("koneksi.php");

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST["email"];
    $nama_bank = $_POST["nama_bank"];
    $atas_nama_rekening = $_POST["atas_nama_rekening"];
    $nomer_rekening = $_POST["nomer_rekening"];
    $salary = $_POST["salary"];

    $perintah = "SELECT * FROM tb_dokter where email = '$email'";
    $eksekusi = mysqli_query($konek, $perintah);
    $cek = mysqli_affected_rows($konek);

    while($ambil = mysqli_fetch_object($eksekusi)){
        
        $id = $ambil->id;
        
        $perintah_update_data_salary = "UPDATE tb_salary_dokter SET nama_bank='$nama_bank', atas_nama_rekening='$atas_nama_rekening', nomer_rekening='$nomer_rekening', salary='$salary' WHERE id_dokter='$id'";
        $eksekusi_update_data_salary = mysqli_query($konek, $perintah_update_data_salary);
        $cek_update = mysqli_affected_rows($konek);

        if($cek_update > 0){
            $response["kode"] = 1;
            $response["pesan"] = "Simpan Data Berhasil";
        }
        else{
            $response["kode"] = 0;
            $response["pesan"] = "Gagal Menyimpan Data";
        }

    }

}
else{
    $response["kode"] = 0;
    $response["pesan"] = "Tidak Ada Post Data";
}

echo json_encode($response);
mysqli_close($konek);