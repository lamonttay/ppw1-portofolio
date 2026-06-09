<?php
include_once("config.php");
if (isLoggedIn()) { header('Location: index.php'); exit(); }
$error = ''; $success = isset($_GET['registered']) ? 'Registrasi berhasil. Silakan login.' : '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$username'");
    if ($res && mysqli_num_rows($res) == 1 && password_verify($_POST['password'] ?? '', ($user = mysqli_fetch_assoc($res))['password'])) {
        $_SESSION['user_id'] = $user['id']; $_SESSION['username'] = $user['username']; $_SESSION['full_name'] = $user['full_name'];
        header('Location: index.php'); exit();
    }
    $error = 'Username atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100 d-flex align-items-center justify-content-center">
<div class="card p-4 shadow-sm border-0 w-100" style="max-width: 380px;">
    <h5 class="text-center mb-3 fw-bold">Masuk Sistem</h5>
    <?php if ($error) echo '<div class="alert alert-danger p-2 small text-center">'.$error.'</div>'; ?>
    <?php if ($success) echo '<div class="alert alert-success p-2 small text-center">'.$success.'</div>'; ?>

    <form method="POST">
        <div class="mb-2"><label class="form-label small mb-1">Username / Email</label><input type="text" name="username" class="form-control form-control-sm" required autocomplete="off"></div>
        <div class="mb-3"><label class="form-label small mb-1">Password</label><input type="password" name="password" class="form-control form-control-sm" required></div>
        <button type="submit" name="login" class="btn btn-primary btn-sm w-100 fw-medium">Login</button>
    </form>
    <div class="text-center small text-muted mt-3">Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar Akun</a></div>
</div>
</body>
</html>