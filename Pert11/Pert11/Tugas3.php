<?php
date_default_timezone_set('Asia/Jakarta');

$bulan = date('F');
$tanggal = date('d');
$totalHari = date('t');
$sisaHari = $totalHari - $tanggal;

echo "Bulan sekarang: " . $bulan . "<br>";
echo "Tanggal hari ini: " . $tanggal . "<br>";
echo "Sisa hari bulan ini: " . $sisaHari;
?>