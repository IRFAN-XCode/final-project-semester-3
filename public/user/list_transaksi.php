<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../sidebar.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/transaksi.php';

$transaksi_obj = new Transaksi($conn);
$id_user = $_SESSION['user_id'];

$transaksi_list = $transaksi_obj->readAll($id_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Transaksi</title>
    <link rel="stylesheet" href="../../assets/user_style.css"> 
</head>

<body>
    <header class="top-header">
        <button id="toggleSidebar" class="hamburger">☰</button>
        <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
    </header>

    <h2 style="font-size: 40px;">Daftar Transaksi</h2>
    <div id="transactions-list-content">

            <button><a class="link" href="tambah_transaksi.php">Tambah</a></button>
            <button><a class="link" href="dashboard.php">Kembali</a></button>
            <button><a class="link" href="laporan.php?action=download">Download Laporan</a></button>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Transaksi</th>
                    <th>Nominal</th>
                    <th>Nominal (IDR)</th>
                    <th>Kategori</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($transaksi_list)): ?>
                    <?php foreach ($transaksi_list as $t): ?>
                        <tr>
                            <td data-label="Tanggal"><?= htmlspecialchars($t['tanggal']) ?></td>
                            <td data-label="Nama Transaksi"><?= htmlspecialchars($t['nama_transaksi']) ?></td>
                            <td data-label="Nominal"><?= htmlspecialchars($t['nominal']) . ' ' . htmlspecialchars($t['mata_uang'])?></td>
                            <td data-label="Nominal (IDR)">Rp <?= number_format($t['nominal_idr'], 0, ',', '.') ?></td>
                            <td data-label="Kategori"><?= htmlspecialchars($t['kategori']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Belum ada transaksi yang dicatat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
