<?php
include_once("config.php"); requireLogin();
$errors = []; $success = '';

if (isset($_POST['submit'])) {
    foreach (['nim', 'nama', 'jurusan', 'email', 'alamat'] as $f) $$f = mysqli_real_escape_string($conn, $_POST[$f] ?? '');

    if (!$nim || !$nama || !$jurusan || !$email) $errors[] = 'Semua kolom * wajib diisi!';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid!';
    if (mysqli_num_rows(mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim='$nim'"))) $errors[] = 'NIM sudah terdaftar!';

    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $upload = uploadFile($_FILES['foto']);
        $upload['success'] ? $foto = $upload['filename'] : $errors[] = $upload['message'];
    }

    if (empty($errors)) {
        $foto_sql = $foto ? "'$foto'" : 'NULL';
        if (mysqli_query($conn, "INSERT INTO mahasiswa (nim, nama, jurusan, email, alamat, foto) VALUES ('$nim','$nama','$jurusan','$email','$alamat',$foto_sql)")) { $success = 'Data berhasil ditambahkan!'; $_POST = []; } 
        else { $errors[] = 'Gagal menyimpan data.'; if ($foto) deleteFile($foto); }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 450px;">
    <a href="index.php" class="text-decoration-none small text-secondary d-inline-block mb-2 fw-medium">← Kembali ke Dashboard</a>
    <div class="card p-3 shadow-sm border-0">
        <h5 class="text-center mb-3 fw-bold">Tambah Mahasiswa</h5>
        <?php if ($errors) echo '<div class="alert alert-danger p-2 small">'.implode('<br>', $errors).'</div>'; ?>
        <?php if ($success) echo '<div class="alert alert-success p-2 small">'.$success.'</div>'; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-2"><label class="form-label small mb-1">Foto Profil</label><input type="file" name="foto" accept="image/*" class="form-control form-control-sm"></div>
            <?php foreach(['nim'=>'NIM *', 'nama'=>'Nama Lengkap *', 'jurusan'=>'Jurusan *', 'email'=>'Email *'] as $k => $v): ?>
                <div class="mb-2"><label class="form-label small mb-1"><?= $v ?></label><input type="<?= $k=='email'?'email':'text' ?>" name="<?= $k ?>" class="form-control form-control-sm" value="<?= htmlspecialchars($_POST[$k] ?? '') ?>" required></div>
            <?php endforeach; ?>
            <div class="mb-3"><label class="form-label small mb-1">Alamat</label><textarea name="alamat" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea></div>
            <div class="d-flex gap-2"><button type="submit" name="submit" class="btn btn-primary btn-sm flex-grow-1">Simpan</button><a href="index.php" class="btn btn-secondary btn-sm px-3">Batal</a></div>
        </form>
    </div>
</div>
</body>
</html>