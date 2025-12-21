<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../sidebar.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/routine_cash.php';

$message = '';
$routine_cash = new RoutineCash($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama = $_POST['nama_pengeluaran'];
    $nominal = (int)$_POST['nominal'];
    $tgl_jatuh_tempo = $_POST['tgl_jatuh_tempo'];
    $frekuensi = $_POST['frekuensi'];

    if ($routine_cash->create($user_id, $nama, $nominal, $tgl_jatuh_tempo, $frekuensi)) {
        echo "<script>
            alert ('DATA BERHASIL DITAMBAHKAN')
            window.location.href='dashboard.php';
            </script>";    
    } else {
        $message = "Gagal menambahkan tagihan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Pengeluaran Rutin</title>
    <link rel="stylesheet" href="../../assets/user_style.css"> 
</head>

<body>
    <header class="top-header">
        <button id="toggleSidebar" class="hamburger">☰</button>
            <img src="<?= BASE_URL ?>assets/finance-care2.jpg" alt="Logo Financial Care">
    </header>

    <button id="btn-back"><a href="dashboard.php">Kembali</a></button>
    
    <div id="add-container">
        <h2 id="title-crud">Tambah Tagihan</h2>
        <p><?= $message ?></p>
            <form method="POST">
                <label for="nama_pengeluaran">Nama Pengeluaran:</label><br>
                <input type="text" id="nama_pengeluaran" name="nama_pengeluaran" required><br><br>

                <label for="nominal">Nominal (IDR):</label><br>
                <input type="number" id="nominal_" name="nominal" required min="1"><br><br>

                <label for="tgl_jatuh_tempo">Tanggal Jatuh Tempo</label><br>
                <input type="date" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" required><br><br>

                <label for="frekuensi">Frekuensi:</label><br>
                <select id="frekuensi" name="frekuensi" required>
                    <option value="Bulanan">Bulanan</option>
                    <option value="Tahunan">Tahunan</option>
                    <option value="Semester">Semester</option>
                </select><br><br>

                <button class="btn" type="submit">Simpan</button>
            </form>
    </div>
</body>
</html>