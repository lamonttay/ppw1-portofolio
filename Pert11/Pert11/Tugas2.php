<?php
function hitungIMT($berat, $tinggi){
    $tinggiMeter = $tinggi / 100;
    $imt = $berat / ($tinggiMeter * $tinggiMeter);

    if($imt < 18.5){
        return "Kurus";
    } elseif($imt < 22.9){
        return "Normal";
    } elseif($imt < 24.9){
        return "Gemuk";
    } else {
        return "Obesitas";
    }
}

$hasil = hitungIMT(58, 174);
echo "Kategori IMT: " . $hasil;
?>