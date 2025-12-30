<?php
session_start();

require_once 'env.php';
require_once 'config.php';
require_once 'db.php';
require_once 'classes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth($conn);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        
        if ($_SESSION['role'] === 'admin') {
            echo "<script>
                alert('Login Admin BERHASIL!');
                window.location.href='public/admin/dashboard_admin.php';
                </script>";
            exit;
        } else {
            echo "<script>
                alert('Login Mahasiswa BERHASIL!');
                window.location.href='public/user/dashboard.php';
                </script>";
            exit;
        }

    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Keuangan Mahasiswa</title>
    <link rel="stylesheet" href="assets/auth_style.css">
    
</head>
<body>
    <div class="login-container">
        <div id="logos">
            <img src="<?= BASE_URL ?>/assets/logo-login.jpg" alt="Logo Finance Care">
        </div>

        <form method="POST">
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Nama Lengkap" required><br><br>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <h5><a style="font-size: 12px; text-decoration: none;" href="public/user/lupa_password.php">Lupa Password?</a></h5>
            
            <p style="color: red; text-align: center;"><?= $error ?></p>
            <button class="btn" type="submit">Masuk</button>
        </form>

        <p style="text-align: center;">Belum punya akun? <a class="link" href="register.php">Registrasi di sini</a></p>
    </div>
</body>
</html>
