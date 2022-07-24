<?php
require("koneksi.php");

$response = array();

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
        
        $perintah_create_data_salary = "INSERT INTO tb_salary_dokter(id_dokter, nama_bank, atas_nama_rekening, nomer_rekening, salary) VALUES ('$id', '$nama_bank', '$atas_nama_rekening', '$nomer_rekening', '$salary')";
        $eksekusi_create_data_salary = mysqli_query($konek, $perintah_create_data_salary);
        $cek = mysqli_affected_rows($konek);

        if($cek > 0){
            $response["kode"] = 1;
            $response["pesan"] = "Simpan Data Berhasil";
        }
        else{
            $response["kode"] = 0;
            $response["pesan"] = "Gagal Menyimpan Data";
        }

    }

    echo json_encode($response);
    mysqli_close($konek);
// batas

// $response = array();

// if($_SERVER['REQUEST_METHOD'] == 'POST'){

//     $nama_bank = $_POST["nama_bank"];
//     $atas_nama_rekening = $_POST["atas_nama_rekening"];
//     $nomer_rekening = $_POST["nomer_rekening"];
//     $salary = $_POST["salary"];
    
//     $perintah = "INSERT INTO tb_salary_dokter(nama_bank, atas_nama_rekening, nomer_rekening, salary) VALUES ('$nama_bank', '$atas_nama_rekening', '$nomer_rekening', '$salary')";
//     $eksekusi = mysqli_query($konek, $perintah);
//     $cek = mysqli_affected_rows($konek);

//     if($cek > 0){
//         $response["kode"] = 1;
//         $response["pesan"] = "Simpan Data Berhasil";
//     }
//     else{
//         $response["kode"] = 0;
//         $response["pesan"] = "Gagal Menyimpan Data";
//     }
// }
// else{
//     $response["kode"] = 0;
//     $response["pesan"] = "Tidak Ada Post Data";
// }

// echo json_encode($response);
// mysqli_close($konek);