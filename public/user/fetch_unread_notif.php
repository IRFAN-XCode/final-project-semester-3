<?php
session_start();
require_once __DIR__ . '/../../db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT COUNT(*) AS jml 
        FROM notifications 
        WHERE user_id = $user_id AND is_read = 0";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

echo $data['jml'];
?>
