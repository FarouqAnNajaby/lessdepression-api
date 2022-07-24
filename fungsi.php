<?php

function getIndikasi($arr1, $arr2)
{
	/*
	*	Catatan ::
	*	array_intersect = Mencari nilai yang sama dari dua array
	*	array_values = Reset index array ke-0, soalnya array_intersect bakal mulai index dari ke-1
	*	Contoh :
	*	$arr1 = ['apel', 'pisang', 'buah naga'];
	*	$arr1 = ['apel', 'jeruk', 'kelapa'];
	*	$hasil = array_intersect($arr1, $arr2);
	*	================================================
	*	Sebelum array values, Hasil Array ( [1] => 'apel' )
	*	================================================
	*	$hasil = array_values(array_intersect($arr1, $arr2));
	*	================================================
	*	Setelah array values, Hasil Array ( [0] => 'apel' )
	*	================================================
	*/
	if ($arr1 == 0 && $arr2 == 0) {
		return 0;
	} else if ($arr1 == 0) {
		return $arr2;
	} else if ($arr2 == 0) {
		return $arr1;
	}
	$result = array_intersect($arr1, $arr2);
	if (count($result) == 0) {
		return 0;
	}
	return array_values($result);
}

function getNonDuplicateIndikasi($arr)
{
	$result = [];
	foreach ($arr as $index => $value) {
		$result[] = $value['indikasi'];
	}
	$result = array_values(array_unique($result, SORT_REGULAR));
	return $result;
}

function getResult($gejala)
{
	$result = '';
	$count = count($gejala);
	$end = ($count > 2) ? $count : ($count - 1);

	for ($i = 0; $i < $end; $i++) {
		if ($i === 0) {
			$firstTwo = array_slice($gejala, 0, 2);
			$gejala = array_slice($gejala, 2);
			$result = calculateDempsterShafer($firstTwo, true);
		} else {
			$newIndikasi = getNonDuplicateIndikasi($result);
			$result = getCalculatedResult($result, $newIndikasi);
			if ($i == $end - 1) {
				break;
			} else {
				array_unshift($result, $gejala[0]);
				$result = calculateDempsterShafer($result);
				if (count($gejala) > 1) {
					$gejala = array_slice($gejala, 1);
				}
			}
		}
	}
	return getFinalResult($result);
}

function getCalculatedResult($arr, $indikasi)
{
	$temporary = [];
	foreach ($arr as $val) {
		foreach ($indikasi as $index => $value) {
			if (!array_key_exists($index, $temporary)) {
				$temporary[$index]['indikasi'] = $value;
				$temporary[$index]['bobot'] = 0;
			}
			if ($val['indikasi'] == $value) {
				$temporary[$index]['bobot'] = $val['bobot'] + $temporary[$index]['bobot'];
			}
		}
	}
	return $temporary;
}

function calculateDempsterShafer($arr, $isFirst = false)
{
	$o = 0;

	$start = $isFirst ? 0 : 1;
	$end =  count($arr);

	for ($i = $start; $i < $end; $i++) {
		for ($j = 0; $j < 2; $j++) {
			if ($isFirst) {
				$result[$o]['indikasi'] = getIndikasi($arr[0]['indikasi'][$j], $arr[1]['indikasi'][$i]);
				$result[$o]['bobot'] = calculateMultiply($arr[0]['bobot'][$j], $arr[1]['bobot'][$i]);
			} else {
				$result[$o]['indikasi'] = getIndikasi($arr[0]['indikasi'][$j], $arr[$i]['indikasi']);
				$result[$o]['bobot'] = calculateMultiply($arr[0]['bobot'][$j], $arr[$i]['bobot']);
			}
			$o++;
		}
	}
	return $result;
}

function calculateMultiply($num1, $num2)
{
	return floatval(rtrim(bcmul($num1, $num2, 4), '0'));
}

function getFinalResult($arr)
{
	foreach ($arr as $index => $val) {
		$bobot[] = $val['bobot'];
	}
	$max = max($bobot);
	$index = array_search($max, array_column($arr, 'bobot'));
	$result = $arr[$index];
	return $result;
}

function generateRandom($length = 5, $lower_case = false)
{
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$number = '1234567890';
	if($lower_case) {
		$alphabet .= strtolower($alphabet);
	}
	$word = $alphabet . $number;
	$result = '';
	for ($i = 0; $i < $length; $i++) {
		$result .= $word[rand(0, strlen($word) - 1)];
	}
	return $result;
}
