<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../db.php';

function downloadCSV($conn, $id_user) {
    $filename = "laporan_transaksi_" . date('Ymd') . ".csv";
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, array('ID', 'Nama Transaksi', 'Nominal', 'Kategori', 'Tanggal', 'Keterangan'));

    $sql = "SELECT id_transaksi, nama_transaksi, nominal_idr, kategori, tanggal, keterangan FROM transaksi WHERE id_user = " . $id_user . " ORDER BY tanggal DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'download') {
    downloadCSV($conn, $_SESSION['user_id']);
}
?>
