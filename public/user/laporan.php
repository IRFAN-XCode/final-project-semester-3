<?php
// public/laporan.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../db.php';

// Fungsi untuk membuat dan mengunduh CSV
function downloadCSV($conn, $id_user) {
    $filename = "laporan_transaksi_" . date('Ymd') . ".csv";
    
    // Set header untuk download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Header Kolom
    fputcsv($output, array('ID', 'Nama Transaksi', 'Nominal', 'Kategori', 'Tanggal', 'Keterangan'));

    // Ambil data
    $sql = "SELECT id_transaksi, nama_transaksi, nominal_idr, kategori, tanggal, keterangan FROM transaksi WHERE id_user = " . $id_user . " ORDER BY tanggal DESC";
    $result = $conn->query($sql);

    // Isi Data
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit; // Penting untuk menghentikan output lain
}

if (isset($_GET['action']) && $_GET['action'] == 'download') {
    downloadCSV($conn, $_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Keuangan</title>
</head>
<body>
    <h2>Laporan Keuangan</h2>
    <p>Anda dapat mengunduh semua data transaksi sebagai file CSV untuk analisis lebih lanjut.</p>
    <p><a href="laporan.php?action=download">**Unduh Laporan Transaksi (CSV)**</a></p>
    <p><a href="dashboard.php">Kembali ke Dashboard</a></p>
</body>
</html>