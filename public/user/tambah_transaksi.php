<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../env.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/kurs_client.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_user = $_SESSION['user_id'];
    $nama = $_POST['nama_transaksi'];
    $nominal = (float)$_POST['nominal'];
    $mata_uang = $_POST['mata_uang'];
    $kategori = $_POST['kategori'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $kurs_rate = 1;
    $nominal_idr = $nominal;

    if ($mata_uang != "IDR") {

        $kurs = new ApiClientKurs();
        $rate = $kurs->getRate($mata_uang, "IDR");

        if ($rate !== false) {
            $kurs_rate = $rate;
            $nominal_idr = $nominal * $rate;
        } else {
            $kurs_rate = 1;
            $nominal_idr = $nominal; 
        }
    }

    $query = "INSERT INTO transaksi (user_id, nama_transaksi, nominal, mata_uang, kurs_rate, nominal_idr, kategori, tanggal, keterangan)
              VALUES ('$id_user', '$nama', '$nominal', '$mata_uang', '$kurs_rate', '$nominal_idr', '$kategori', '$tanggal', '$keterangan')
             ";

    mysqli_query($conn, $query);
    header("Location: list_transaksi.php");
    exit;
}
require_once __DIR__ . '/../../sidebar.php';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="../../assets/user_style.css"> 
</head>

<body>
    <header class="top-header">
        <button id="toggleSidebar" class="hamburger">☰</button>
        <img src="<?= BASE_URL ?>assets/finance-care2.jpg" alt="Logo Financial Care">
    </header>
    <button id="btn-back"><a href="list_transaksi.php">Kembali</a></button>

    <div id="add-container">
        <h2 id="title-crud">Tambah Transaksi</h2>
        <form action="" method="POST">
            <label for="nama_transaksi">Nama Transaksi:</label>
            <input type="text" id="nama_transaksi" name="nama_transaksi" required><br><br>

            <label for="nominal">Nominal (Kurs Asing):</label><br>
            <input type="number" id="nominal" name="nominal" required min="1">

            <label for="mata_uang"></label>
            <select name="mata_uang" id="mata_uang">
                <option value="IDR">IDR</option>
                <option value="SGD">SGD</option>
                <option value="EUR">EUR</option>
                <option value="JPY">JPY</option>
                <option value="CNY">CNY</option>
                <option value="USD">USD</option>
                <option value="AUD">AUD</option>
                <option value="KRW">KRW</option>
                <option value="THB">THB</option>
                <option value="GBP">GBP</option>
            </select><br><br>

            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Makanan">Makanan</option>
                <option value="Transportasi">Transportasi</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Lainnya">Lainnya</option>
            </select><br><br>

            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required><br><br>

            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan"></textarea><br><br>

            <button class="btn" type="submit">Simpan Transaksi</button>
        </form>
    </div>
</body>
</html>