<?php
include_once("config.php"); requireLogin();
$id = (int)($_GET["id"] ?? 0);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id"));
if (!$row) { header('Location: index.php'); exit(); }
$errors = [];

if (isset($_POST['update'])) {
    foreach (['nim', 'nama', 'jurusan', 'email', 'alamat'] as $f) $$f = mysqli_real_escape_string($conn, $_POST[$f] ?? '');
    if (!$nim || !$nama || !$jurusan || !$email) $errors[] = 'Semua kolom * wajib diisi!';
    if (mysqli_num_rows(mysqli_query($conn, "SELECT id FROM mahasiswa WHERE nim='$nim' AND id != $id"))) $errors[] = 'NIM sudah terdaftar!';
    
    $foto = $row['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $up = uploadFile($_FILES['foto']);
        if ($up['success']) { if($foto) deleteFile($foto); $foto = $up['filename']; } else $errors[] = $up['message'];
    }
    if (($_POST['hapus_foto'] ?? '') == '1') { if($foto) deleteFile($foto); $foto = null; }

    if (empty($errors) && mysqli_query($conn, "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan', email='$email', alamat='$alamat', foto=" . ($foto ? "'$foto'" : "NULL") . " WHERE id=$id")) {
        $_SESSION['message'] = 'Data diperbarui!'; header('Location: index.php'); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Edit</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light py-4">
<div class="container" style="max-width: 400px;"><div class="card p-3 shadow-sm border-0">
    <h5 class="text-center mb-3 fw-bold">Edit Mahasiswa</h5>
    <?php if ($errors) echo '<div class="alert alert-danger p-2 small">'.implode('<br>', $errors).'</div>'; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-2 text-center">
            <?= $row['foto'] ? '<img src="uploads/mahasiswa/'.$row['foto'].'" class="rounded-circle border mb-1" style="width:50px;height:50px;object-fit:cover;"><br><label class="small text-muted"><input type="checkbox" name="hapus_foto" value="1"> Hapus foto</label>' : '' ?>
            <input type="file" name="foto" accept="image/*" class="form-control form-control-sm mt-1">
        </div>
        <?php foreach(['nim'=>'NIM *', 'nama'=>'Nama Lengkap *', 'jurusan'=>'Jurusan *', 'email'=>'Email *'] as $k => $v): ?>
            <div class="mb-2"><label class="form-label small mb-1"><?= $v ?></label><input type="<?= $k=='email'?'email':'text' ?>" name="<?= $k ?>" class="form-control form-control-sm" required value="<?= htmlspecialchars($row[$k]) ?>"></div>
        <?php endforeach; ?>
        <div class="mb-3"><label class="form-label small mb-1">Alamat</label><textarea name="alamat" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($row['alamat']) ?></textarea></div>
        <div class="d-flex gap-2"><button type="submit" name="update" class="btn btn-primary btn-sm w-100">Simpan</button><a href="index.php" class="btn btn-secondary btn-sm px-3">Batal</a></div>
    </form>
</div></div>
</body>
</html>