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

$id = $_GET['id'];
$routine_cash = new RoutineCash($conn);
$data_tagihan = $routine_cash->getTransaksiById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_pr = $_POST['nama_tagihan'];
    $nominal = $_POST['nominal'];
    $tgl = $_POST['jatuh_tempo'];
    $frekuensi = $_POST['frekuensi'];

    if ($update_tagihan = $routine_cash->update(
        $id, $nama_pr, $nominal, $tgl, $frekuensi)) {
        echo "<script>
            alert ('TAGIHAN BERHASIL DIUBAH')
            window.location.href='dashboard.php';
            </script>";
    } else {
        echo "<script>
            alert ('TAGIHAN GAGAL DIUBAH')
            window.history.back='edit_tagihan.php';
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tagihan</title>
    <link rel="stylesheet" href="../../assets/user_style.css"> 
</head>

<body>
    <header class="top-header">
        <button id="toggleSidebar" class="hamburger">☰</button>
            <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
    </header>

    <button id="btn-back"><a href="dashboard.php">Kembali</a></button>
    
    <div id="add-container">
        <h2 id="title-crud">Edit Tagihan</h2>
        
            <form action="" method="POST">
            <input type="hidden" name="id" id="id" value="<?= $data_tagihan["id_pr"] ?>">

                <label for="nama_tagihan">Nama Tagihan</label>
                <input type="text" id="nama_tagihan" name="nama_tagihan" value="<?= $data_tagihan["nama_pengeluaran"] ?>"><br><br>

                <label for="nominal">Nominal</label><br>
                <input type="number" id="nominal_" name="nominal" value="<?= $data_tagihan["nominal"] ?>"><br><br>

                <label for="jatuh_tempo">Tanggal Jatuh Tempo</label><br>
                <input type="date" id="jatuh_tempo" name="jatuh_tempo" value="<?= $data_tagihan["tgl_jatuh_tempo"] ?>"><br><br>

                <label for="frekuensi">Frekuensi</label>
                <select name="frekuensi" id="frekuensi">
                    <option value="Bulanan">Bulanan</option>
                    <option value="Tahunan">Tahunan</option>
                    <option value="Semester">Semester</option>
                </select>

                <button class="btn" type="submit" name="submit">Simpan</button>
        </form>
    </div>
</body>
</html>