<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/admin.php';

// Cek autentikasi dan otorisasi admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard_admin.php");
    exit;
}
$admin_service = new Admin($conn);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $delete_success = $admin_service->deleteUser($id);

    if ($delete_success) {
        echo "<script>
            alert ('DATA BERHASIL DIHAPUS')
            window.location.href='dashboard_admin.php';
            </script>";
    } else {
        header("Location: dashboard_admin.php?message=Gagal menghapus user dengan ID $id_user.");
    }
} else {
    header("Location: dashboard_admin.php?message=ID user tidak valid!");
}
exit;