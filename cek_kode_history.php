<?php
require("koneksi.php");

$kode_history = $_POST["kode_history"];
        
    // $kode_history = "766I3";

    $perintah_cek_kode_history = "SELECT kode_history FROM tb_history_hasil where kode_history = '$kode_history'";
    $eksekusi_cek_kode_history = mysqli_query($konek, $perintah_cek_kode_history);
    $cek = mysqli_affected_rows($konek);

    if($cek > 0){
        $response["kode"] = 1;
        $response["pesan"] = "Data Tersedia";
        $response["data"] = array();

        // while($ambil = mysqli_fetch_object($eksekusi_cek_kode_history)){

        //     $response["tanggal"] = date('Y-m-d', strtotime($ambil->tanggal));
        //     $tanggal = date('Y-m-d');

        //     if($tanggal == $response["tanggal"]){
        //         $response["kondisi"] = "True";
        //     }else{
        //         $response["kondisi"] = "False";
        //     }
        // }
        
    }else{
        $response["kode"] = 0;
        $response["pesan"] = "Data Tidak Tersedia";
    }

    echo json_encode($response);
    mysqli_close($konek);