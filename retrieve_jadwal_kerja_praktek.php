<?php
require("koneksi.php");

$kerja_praktek = $_POST["kerja_praktek"];

// $kerja_praktek = "Selasa";

$perintah = "SELECT * FROM tb_dokter WHERE kerja_praktek = '$kerja_praktek'";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $F["id"] = $ambil->id;
        $F["nip"] = $ambil->nip;
        $F["nama_lengkap"] = $ambil->nama_lengkap;
        $F["kelamin"] = $ambil->kelamin;
        $F["bidang_keahlian"] = $ambil->bidang_keahlian;
        $F["gelar_sarjana"] = $ambil->gelar_sarjana;
        $F["kantor"] = $ambil->kantor;
        $F["kerja_praktek"] = $ambil->kerja_praktek;
        $F["email"] = $ambil->email;
		$imageFile = file_get_contents($ambil->lokasi_foto);
		$F["foto"] = base64_encode($imageFile);

        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);

?>