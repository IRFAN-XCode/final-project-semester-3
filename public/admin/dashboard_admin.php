<?php
session_start();
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/admin.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /../../index.php"); 
    exit;
}

$admin_service = new Admin($conn);
$users = $admin_service->getAllUsers();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../../assets/admin_style.css"> 
</head>

<body>
    <div class="container">
        
        <header class="header">
            <div class="user-info">
                <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
                <h2>Dashboard Admin</h2>
                <a href="kirim_notif.php">Kirim Notifikasi</a>
                <a href="../../logout.php" style="color: #ef4444">Logout</a>
            </div>
        </header>

        <p style="text-align: center; font-size: 25px; color: #0019FF; margin: 20px;" >Daftar Mahasiswa</p>

        <div class="table-wrapper">

            <table class="table">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['nim']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['Email']) ?></td>
                                <td><?= htmlspecialchars($user['Program_studi']) ?></td>
                                <td id="action-link">
                                    <a id="edit-link" href="edit_data.php?id=<?= $user['id']; ?>">Edit</a>
                                    <a id="delete-link" href="hapus_data.php?id=<?= $user['id']; ?>" onclick=" return confirm
                                    ('Apakah anda ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>