<?php
include_once("config.php"); requireLogin();
$id = (int)($_GET['id'] ?? 0);
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = $id");
$row = mysqli_fetch_assoc($result);
if (!$row) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5" style="max-width: 400px;">
    <div class="card p-3 border-0 shadow-sm">
        <h5 class="fw-bold text-center mb-3">Detail Mahasiswa</h5>
        <div class="text-center mb-3"><?= $row['foto'] ? '<img src="uploads/mahasiswa/'.$row['foto'].'" class="rounded-circle border" style="width:100px;height:100px;object-fit:cover;">' : 'N/A' ?></div>
        <div class="small mb-3">
            <p class="mb-1"><b>NIM:</b> <?= htmlspecialchars($row['nim']) ?></p>
            <p class="mb-1"><b>Nama:</b> <?= htmlspecialchars($row['nama']) ?></p>
            <p class="mb-1"><b>Jurusan:</b> <?= htmlspecialchars($row['jurusan']) ?></p>
            <p class="mb-1"><b>Email:</b> <?= htmlspecialchars($row['email']) ?></p>
            <p class="mb-1"><b>Alamat:</b> <?= htmlspecialchars($row['alamat']) ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-secondary btn-sm w-100">Kembali</a>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white w-100">Edit</a>
        </div>
    </div>
</body>
</html>