<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/routine_cash.php';

$routine_cash = new RoutineCash($conn);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $delete_tagihan = $routine_cash->delete($id);

    if ($delete_tagihan) {
        echo "<script>
            alert ('TAGIHAN BERHASIL DIHAPUS')
            window.location.href='dashboard.php';
            </script>";
    } else {
        echo "<script>
            alert ('TAGIHAN GAGAL DIHAPUS')
            window.location.href='dashboard.php';
            </script>";
    }
}
?>
