<?php
require("koneksi.php");

$response['kode'] = 0;
$response['pesan'] = 'Data tidak ditemukan';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$id_pengguna = $_POST['id_pengguna'];
	$kode_history = $_POST['kode_history'];

	$perintah = "SELECT th.kode_history, th.tanggal, thh.indikasi, thh.nilai_akhir
            FROM tb_history th
            INNER JOIN tb_history_hasil thh ON thh.kode_history = th.kode_history
            WHERE  th.id_pengguna = '$id_pengguna' AND th.kode_history = '$kode_history'";

	if ($result = mysqli_query($konek, $perintah)) {
		$data = mysqli_fetch_object($result);
		/*
        *   array $row['indikasi']
        *   assoc $row['indikasi'], $row->indikasi
        *   object $row->indikasi
        */

		$waktu = formatWaktu($data->tanggal);
		$hari = formatHari($data->tanggal);
		$bulanThn = formatBulanThn($data->tanggal);
		$tanggal = "$hari, $bulanThn";

		$hasil["tanggal"] = $tanggal;
		$hasil["waktu"] = $waktu;
		$hasil["indikasi"] = $data->indikasi;
		$hasil["nilai_akhir"] = $data->nilai_akhir;

		$query = "SELECT tdg.nama_gejala
                    FROM tb_history_pilihan thp
                    INNER JOIN tb_data_gejala tdg ON thp.kode_gejala = tdg.kode_gejala
                    WHERE thp.kode_history = '$data->kode_history'";

		if ($result = mysqli_query($konek, $query)) {
			while ($row = mysqli_fetch_object($result)) {
				$hasil['gejala'][] = $row->nama_gejala;
			}
			$response['kode'] = 1;
			$response['pesan'] = $hasil;
		}
	}
	mysqli_close($konek);

	print(json_encode($response));
}



function formatHari($tanggal)
{
	$hari = date("D", strtotime($tanggal));
	if ($hari == 'Sun') {
		$hari = 'Minggu';
	} else if ($hari == 'Mon') {
		$hari = 'Senin';
	} else if ($hari == 'Tue') {
		$hari = 'Selasa';
	} else if ($hari == 'Wed') {
		$hari = 'Rabu';
	} else if ($hari == 'Thu') {
		$hari = 'Kamis';
	} else if ($hari == 'Fri') {
		$hari = 'Jum\'at';
	} else if ($hari == 'Sat') {
		$hari = 'Sabtu';
	}
	return $hari;
}

function formatBulanThn($tanggal)
{
	$bulan = date('M', strtotime($tanggal));
	$tahun = date('Y', strtotime($tanggal));
	$tanggal = date('j', strtotime($tanggal));

	if ($bulan == 'Jan') {
		$bulan = 'Januari';
	} else if ($bulan == 'Feb') {
		$bulan = 'Februari';
	} else if ($bulan == 'Mar') {
		$bulan = 'Maret';
	} else if ($bulan == 'Apr') {
		$bulan = 'April';
	} else if ($bulan == 'May') {
		$bulan = 'Mei';
	} else if ($bulan == 'Jun') {
		$bulan = 'Juni';
	} else if ($bulan == 'Jul') {
		$bulan = 'Juli';
	} else if ($bulan == 'Aug') {
		$bulan = 'Agustus';
	} else if ($bulan == 'Sep') {
		$bulan = 'September';
	} else if ($bulan == 'Oct') {
		$bulan = 'Oktober';
	} else if ($bulan == 'Nov') {
		$bulan = 'November';
	} else if ($bulan == 'Dec') {
		$bulan = 'Desember';
	}
	return "$tanggal $bulan $tahun";
}

function formatWaktu($tanggal)
{
	return date('H:i', strtotime($tanggal));
}
