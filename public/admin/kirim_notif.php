<?php
session_start();
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/notifications_service.php';

if ($_SESSION['role'] !== 'admin') {
    exit("Akses ditolak");
}

$users = mysqli_query($conn, "SELECT id, username, Email FROM profil WHERE role = 'mahasiswa'");
$notif = new NotificationsService($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_POST['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $q = mysqli_query($conn, "SELECT Email FROM profil WHERE id = $user_id");
    $user = mysqli_fetch_assoc($q);

    if ($user) {
        $notif->sendNotification($user_id, $user['Email'], $subject, $message);
        echo "<script>
                alert ('NOTIFIKASI BERHASIL DIKIRIM')
                window.location.href='kirim_notif.php';
                </script>";
    } else {
        echo "<script>
                alert ('MAHASISWA TIDAK DAPAT DITEMUKAN')
                window.location.href='kirim_notif.php';
                </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi</title>
    <link rel="stylesheet" href="../../assets/admin_style.css"> 
</head>

<body class="container">
        <header class="header">
            <div class="user-info">
                <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
                <h2>Panel Notifikasi</h2>
                <a href="dashboard_admin.php" class="logout-link">Kembali</a>
                <a href="../../logout.php" style="color: #ef4444">Logout</a>
            </div>
        </header>
         
        <div id="form-container">
        <form method="POST">
            <label>Pilih User</label><br>
            <select name="user_id" required>
                <option value="">-- Pilih User --</option>
                <?php while ($u = mysqli_fetch_assoc($users)): ?>
                    <option value="<?= $u['id'] ?>">
                        <?= $u['username'] ?> (<?= $u['Email'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <br><br>
                
            <label>Subject</label><br>
            <input type="text" name="subject" required><br><br>
                
            <label>Pesan</label><br>
            <textarea name="message" required></textarea><br><br>
            
            <button id="btn-notif" type="submit">Kirim</button>
        </form>
        </div>
</body>
</html>