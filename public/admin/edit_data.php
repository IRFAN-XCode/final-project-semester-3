<?php
session_start();
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/admin.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /../../index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard_admin.php");
    exit;
}

$id = (int) $_GET['id'];
$admin_service_edit = new Admin($conn);
$user_data = $admin_service_edit->getUserById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nim = $_POST['nim'];
    $email = $_POST['email'];
    $prodi = $_POST['prodi'];

    if (empty($username) || empty($email) || empty($prodi) || empty($nim)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $update_success = $admin_service_edit->updateUser($id, $nim, $username, $email, $prodi);

    if ($update_success) {
        echo "<script>
                alert('DATA MAHASISWA BERHASIL DIUBAH');
                window.location.href='dashboard_admin.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('TERJADI KESALAHAN');
                window.history.back();
              </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../assets/admin_style.css"> 
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="user-info">
                <img src="<?= BASE_URL ?>assets/finance-care2.jpg" alt="Logo Financial Care">
                <h2>Edit Data Mahasiswa</h2>
                <a href="dashboard_admin.php" class="logout-link">Kembali</a>
                <a href="../../logout.php" style="color: #ef4444">Logout</a>
            </div>
        </header>
        <?php $message ?>


        <div id="form-container">
            <form action="" method="POST">

                <input type="hidden" name="id" id="id" value="<?= $user_data["id"]?>">
                
                <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $user_data["username"]?>" required> <br><br>
                </div>

                <div class="form-group">
                <label for="nim">NIM</label>
                <input type="text" id="nim" name="nim" value="<?= $user_data["nim"]?>"><br><br>
                </div>
                
                <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $user_data["Email"]?>" required><br><br>
                </div>

                <label for="prodi">Program Studi</label>
                <select name="prodi" id="prodi">
                    <option value="-">-- Pilih Di sini --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Bisnis Digital">Bisnis Digital</option>
                    <option value="Teknik Industri">Teknik industri</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Akuntansi">Akuntansi</option>
                    <option value="Manajemen">Manajemen</option>
                    <option value="Psikologi">Psikologi</option>
                    <option value="Farmasi">Farmasi</option>
                    <option value="Ilmu Hukum">Ilmu Hukum</option>
                </select>
                <br><br>
                <button id="btn-notif" type="submit" name="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>