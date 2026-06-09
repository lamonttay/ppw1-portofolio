<?php
$nama = "Ariq Muhammad";
$nim = "25/566604/SV/27103";
$prodi = "Teknologi Rekayasa Perangkat Lunak";
$asal = "Jakarta";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Mahasiswa</title>
</head>
<body>
    <table border="1" cellpadding="8">
        <tr>
            <th colspan="2">Profil Mahasiswa</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td><?php echo $nim; ?></td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td><?php echo $prodi; ?></td>
        </tr>
        <tr>
            <td>Asal Kota</td>
            <td><?php echo $asal; ?></td>
        </tr>
    </table>
</body>
</html>