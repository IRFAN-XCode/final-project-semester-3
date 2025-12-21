<?php
session_start();
require_once 'db.php';
require_once 'classes/auth.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth($conn);
    $nim = $_POST['nim'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $prodi = $_POST['prodi'];
    $password = $_POST['password'];
    $konfirm = $_POST['konfirm'];

    if ($password !== $konfirm) {
        $message = "Konfirmasi Password Salah!";
    } 
    elseif ($prodi == "-") {
        $message = "Silakan pilih Program Studi!";
    }

    if (empty($message)) {
        $registerSuccess = $auth->register($nim, $username, $email, $prodi, $password);
        
        if ($registerSuccess) {
            echo "<script>
                alert('REGISTER BERHASIL!');
                window.location.href='index.php';
                </script>";
            exit;
        } else {
            $message = "Registrasi gagal. Coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Registrasi</title>
    <link rel="stylesheet" href="assets/auth_style.css"> 
</head>

<body>
    <div class="register-container">
        <h1 style="font-size: 25px; text-align: center;" >Registrasi Akun Mahasiswa</h1>

        <form method="POST">

            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" placeholder= "Masukkan NIM" required>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Nama Lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
            </div>

            <div class="form-group">
                <label for="prodi">Program Studi:</label>
                <select name="prodi" id="prodi">
                    <option value="-">-- Pilih Di sini --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Bisnis Digital">Bisnis Digital</option>
                    <option value="Teknik Industri">Teknik industri</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Akuntansi">Akuntansi</option>
                    <option value="Manajemen">Manajemen</option>
                    <option value="Psikologi">Psokologi</option>
                    <option value="Farmasi">Farmasi</option>
                    <option value="Ilmu Hukum">Ilmu Hukum</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Buat Password" required>
            </div>

            <div class="form-group">
                <label for="konfirm">Konfirmasi Password:</label>
                <input type="password" id="konfirm" name="konfirm" placeholder="Konfirmasi Password" required>
            </div>

            <button class="btn" type="submit">Daftar</button>
            <?php if(isset($message)) : ?>
                <p style="color:red; text-align: center;"><?= $message ?></p>
            <?php endif; ?>
            <p style="text-align: center;" >Sudah punya akun? <a class="link" href="index.php">Login di sini</a></p>
        </form>

    </div>
</body>
</html>
