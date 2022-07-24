<?php
require("koneksi.php");

$id_pengguna = $_POST["id_pengguna"];

$perintah = "SELECT tb_history.id_pengguna, tb_history.kode_history,tb_history.tanggal,tb_history_hasil.indikasi
FROM tb_history JOIN tb_history_hasil on tb_history.kode_history = tb_history_hasil.kode_history
WHERE tb_history.id_pengguna = '$id_pengguna' ORDER BY tanggal DESC";

$eksekusi = mysqli_query($konek, $perintah);
$cek = mysqli_affected_rows($konek);

if($cek > 0){
    $response["kode"] = 1;
    $response["pesan"] = "Data Tersedia";
    $response["data"] = array();

    while($ambil = mysqli_fetch_object($eksekusi)){
        $waktu = formatWaktu($ambil->tanggal);
        $hari = formatHari($ambil->tanggal);
        $bulanThn = formatBulanThn($ambil->tanggal);
        $tanggal = "$hari, $bulanThn";
        $F["kode_history"] = $ambil->kode_history;
        $F["tanggal"] = $tanggal;
        $F["waktu"] = $waktu;
        $F["indikasi"] = $ambil->indikasi;
        $F["id_pengguna"] = $ambil->id_pengguna;
        array_push($response["data"], $F);
    }
    
}else{
    $response["kode"] = 0;
    $response["pesan"] = "Data Tidak Tersedia";
}

echo json_encode($response);
mysqli_close($konek);

function formatHari($tanggal) {
    $hari = date("D", strtotime($tanggal));
    if($hari == 'Sun') {
        $hari = 'Minggu';
    } else if($hari == 'Mon') {
        $hari = 'Senin';
    } else if($hari == 'Tue') {
        $hari = 'Selasa';
    } else if($hari == 'Wed') {
        $hari = 'Rabu';
    } else if($hari == 'Thu') {
        $hari = 'Kamis';
    } else if($hari == 'Fri') {
        $hari = 'Jum\'at';
    } else if($hari == 'Sat') {
        $hari = 'Sabtu';
    }
    return $hari;
}

function formatBulanThn($tanggal) {
    $bulan = date('M', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
    $tanggal = date('j', strtotime($tanggal));

    if($bulan == 'Jan') {
        $bulan = 'Januari';
    } else if($bulan == 'Feb') {
        $bulan = 'Februari';
    }else if($bulan == 'Mar') {
        $bulan = 'Maret';
    }else if($bulan == 'Apr') {
        $bulan = 'April';
    }else if($bulan == 'May') {
        $bulan = 'Mei';
    }else if($bulan == 'Jun') {
        $bulan = 'Juni';
    }else if($bulan == 'Jul') {
        $bulan = 'Juli';
    }else if($bulan == 'Aug') {
        $bulan = 'Agustus';
    }else if($bulan == 'Sep') {
        $bulan = 'September';
    }else if($bulan == 'Oct') {
        $bulan = 'Oktober';
    }else if($bulan == 'Nov') {
        $bulan = 'November';
    }else if($bulan == 'Dec') {
        $bulan = 'Desember';
    }
    return "$tanggal $bulan $tahun";
}

function formatWaktu($tanggal) {
    return date('G:i', strtotime($tanggal));
}