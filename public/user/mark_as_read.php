<?php
require_once __DIR__ . '/../../db.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "UPDATE notifications SET is_read = 1 WHERE user_id = $user_id";
mysqli_query($conn, $sql);

echo "OK";
?>
