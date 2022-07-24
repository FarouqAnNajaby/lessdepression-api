<?php
require("koneksi.php");

$email = $_POST["email"];

$perintah = "SELECT * FROM tb_dokter where email = '$email'";
$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

    while($ambil = mysqli_fetch_object($eksekusi)){
        $id = $ambil->id;
        
        $perintah_cek_salary = "SELECT * FROM tb_salary_dokter where id_dokter = '$id'";
        $eksekusi_cek_salary = mysqli_query($konek, $perintah_cek_salary);
        $cek = mysqli_affected_rows($konek);

        if($cek > 0){
            $response["kode"] = 1;
            $response["pesan"] = "Data Tersedia";
            $response["data"] = array();

            while($ambil_salary = mysqli_fetch_object($eksekusi_cek_salary)){
                $response["nama_bank"] = $ambil_salary->nama_bank;
                $response["atas_nama_rekening"] = $ambil_salary->atas_nama_rekening;
                $response["nomer_rekening"] = $ambil_salary->nomer_rekening;
                $response["salary"] = $ambil_salary->salary;

            }
            
        }else{
            $response["kode"] = 0;
            $response["pesan"] = "Data Tidak Tersedia";
        }

    }

    echo json_encode($response);
    mysqli_close($konek);