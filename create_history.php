<?php
date_default_timezone_set("Asia/Jakarta");
include("fungsi.php");
require("koneksi.php");

$response = array();
$response['kode'] = 0;
$response['pesan'] = 'Gagal Memproses Data';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// $id_pengguna = 1;
	// $kode_gejala = ['G001', 'G002', 'G008'];
	$id_pengguna = $_POST["id_pengguna"];
	$kode_gejala = $_POST["kode_gejala"];
	$kode_history = generateRandom();
	$tanggal = date('Y-m-d H:i:s');
	$query = "INSERT INTO tb_history (id_pengguna, kode_history, tanggal) VALUES ('$id_pengguna', '$kode_history', '$tanggal')";
	if (mysqli_query($konek, $query)) {
		$query = 'INSERT INTO tb_history_pilihan (kode_history, kode_gejala) VALUES ';
		foreach ($kode_gejala as $index => $value) {
			$query .= "('$kode_history', '$value')";
			if ($index != count($kode_gejala) - 1) {
				$query .= ', ';
			}
		}
		if (mysqli_query($konek, $query)) {
			$kode_gejala = implode("','", $kode_gejala);
			$query = "SELECT tg.depresi_ringan, tg.depresi_sedang, tg.depresi_berat, dg.bobot_gejala, dg.bobot_teta_gejala
						FROM tb_data_gejala dg
						INNER JOIN tb_tingkatan_gejala tg
						ON dg.kode_gejala = tg.kode_gejala
						WHERE dg.kode_gejala 
						IN ('$kode_gejala')
						ORDER BY FIELD(dg.kode_gejala, '$kode_gejala')";
			$sql = mysqli_query($konek, $query);
			if (mysqli_num_rows($sql) > 0) {
				$i = 0;
				while ($row = mysqli_fetch_object($sql)) {
					$indikasi = [];
					if ($row->depresi_ringan) {
						array_push($indikasi, 'i1');
					}
					if ($row->depresi_sedang) {
						array_push($indikasi, 'i2');
					}
					if ($row->depresi_berat) {
						array_push($indikasi, 'i3');
					}
					$data[$i]['indikasi'] = [$indikasi, 0];
					$data[$i]['bobot'] = [$row->bobot_gejala, $row->bobot_teta_gejala];
					$i++;
				}
				$result = getResult($data);
				$nilai_akhir = $result['bobot'] * 100;
				$indikasi = $result['indikasi'][0];
				if ($indikasi == 'i1') {
					$indikasi = 'ringan';
				} else if ($indikasi == 'i2') {
					$indikasi = 'sedang';
				} else if ($indikasi == 'i3') {
					$indikasi = 'berat';
				} else {
					$indikasi = 'tidak_depresi';
				}
				$query = "INSERT INTO tb_history_hasil (kode_history, indikasi, nilai_akhir) VALUES('$kode_history', '$indikasi', '$nilai_akhir')";
				if (mysqli_query($konek, $query)) {
					$response['kode'] = 1;
					$response['pesan'] = 'Data Berhasil Disimpan';
				} else {
					$query = "DELETE FROM tb_history WHERE kode_history = '$kode_history'";
					mysqli_query($konek, $query);
					$query = "DELETE FROM tb_history_pilihan WHERE kode_history = '$kode_history'";
					mysqli_query($konek, $query);
				}
			} else {
				$response['kode'] = 0;
				$response['pesan'] = 'Data Tidak Ditemukan';
			}
		} else {
			$query = "DELETE FROM tb_history WHERE kode_history = '$kode_history'";
			mysqli_query($konek, $query);
		}
	}
	echo json_encode($response);
}
