<?php
include_once("config.php");
if (isLoggedIn()) { header('Location: index.php'); exit(); }
$errors = [];

if (isset($_POST['register'])) {
    foreach (['full_name', 'username', 'email'] as $f) $$f = mysqli_real_escape_string($conn, trim($_POST[$f] ?? ''));
    $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm_password'] ?? '';

    if (!$full_name || !$username || !$email || !$password) $errors[] = 'Semua kolom wajib diisi!';
    if ($password !== $confirm) $errors[] = 'Konfirmasi password tidak cocok!';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid!';
    if (empty($errors) && mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'")) > 0) $errors[] = 'Username atau email sudah terdaftar!';

    if (empty($errors) && mysqli_query($conn, "INSERT INTO users (full_name, username, email, password) VALUES ('$full_name', '$username', '$email', '" . password_hash($password, PASSWORD_DEFAULT) . "')")) {
        header('Location: login.php?registered=1'); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100 d-flex align-items-center justify-content-center">
<div class="card p-4 shadow-sm border-0 w-100" style="max-width: 380px;">
    <h5 class="text-center mb-3 fw-bold">Daftar Akun</h5>
    <?php if ($errors) echo '<div class="alert alert-danger p-2 small">'.implode('<br>', $errors).'</div>'; ?>

    <form method="POST">
        <?php foreach(['full_name'=>'Nama Lengkap', 'username'=>'Username', 'email'=>'Email'] as $k => $v): ?>
            <div class="mb-2"><label class="form-label small mb-1"><?= $v ?></label><input type="<?= $k=='email'?'email':'text' ?>" name="<?= $k ?>" class="form-control form-control-sm" value="<?= htmlspecialchars($_POST[$k] ?? '') ?>" required></div>
        <?php endforeach; ?>
        <div class="mb-2"><label class="form-label small mb-1">Password</label><input type="password" name="password" class="form-control form-control-sm" required></div>
        <div class="mb-3"><label class="form-label small mb-1">Konfirmasi Password</label><input type="password" name="confirm_password" class="form-control form-control-sm" required></div>
        <button type="submit" name="register" class="btn btn-primary btn-sm w-100 fw-medium">Register</button>
    </form>
    <div class="text-center small text-muted mt-3">Sudah punya akun? <a href="login.php" class="text-decoration-none">Login di sini</a></div>
</div>
</body>
</html>