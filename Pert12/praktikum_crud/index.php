<?php
include_once("config.php"); requireLogin();
$result = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4" style="max-width: 800px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="m-0">Halo, <?= htmlspecialchars($_SESSION['full_name'] ?? '') ?></h6>
        <a href="logout.php" class="btn btn-outline-danger btn-sm" onclick="return confirm('Keluar?')">Logout</a>
    </div>

    <a href="tambah.php" class="btn btn-primary btn-sm mb-3">+ Tambah Mahasiswa</a>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success p-2 small"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-hover table-sm small align-middle">
        <thead class="table-light">
            <tr><th>Foto</th><th>NIM</th><th>Nama</th><th>Jurusan</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <?php if($row['foto']): ?><img src="uploads/mahasiswa/<?= $row['foto'] ?>" class="rounded-circle" style="width:35px;height:35px;object-fit:cover;">
                    <?php else: ?> N/A <?php endif; ?>
                </td>
                <td class="fw-bold"><?= htmlspecialchars($row['nim']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['jurusan']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm py-0 px-2 text-white">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm py-0 px-2" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>