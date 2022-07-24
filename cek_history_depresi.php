<?php
require("koneksi.php");

$email = $_POST["email"];

// $email = "dwikumarawidyatna123@gmail.com";


$perintah = "SELECT * FROM tb_pengguna where email = '$email'";
$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

    while($ambil = mysqli_fetch_object($eksekusi)){
        
        $id = $ambil->id;
        
        $perintah_cek_history_depresi = "SELECT * FROM tb_history where id_pengguna = '$id' ORDER BY id DESC LIMIT 1";
        $eksekusi_cek_history_depresi = mysqli_query($konek, $perintah_cek_history_depresi);
        $cek = mysqli_affected_rows($konek);

        if($cek > 0){
            $response["kode"] = 1;
            $response["pesan"] = "Data Tersedia";
            $response["data"] = array();

            while($ambil_salary = mysqli_fetch_object($eksekusi_cek_history_depresi)){

                $response["tanggal"] = date('Y-m-d', strtotime($ambil_salary->tanggal));
                $tanggal = date('Y-m-d');

                if($tanggal == $response["tanggal"]){
                    $response["kondisi"] = "True";
                }else{
                    $response["kondisi"] = "False";
                }
            }
            
        }else{
            $response["kode"] = 0;
            $response["pesan"] = "Data Tidak Tersedia";
        }

    }

    echo json_encode($response);
    mysqli_close($konek);