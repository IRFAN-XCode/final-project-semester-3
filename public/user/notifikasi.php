<?php
session_start();
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../sidebar.php';


$user_id = $_SESSION['user_id'];

$data = mysqli_query($conn, 
    "SELECT * FROM notifications 
     WHERE user_id = $user_id 
     ORDER BY created_at DESC"
);
?>

<link rel="stylesheet" href="../../assets/user_style.css"> 


<body>
    
    <div class="container">
        <header class="top-header">
            <button id="toggleSidebar" class="hamburger">☰</button>
            <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
        </header>

        <h2 style="font-size: 40px;" >Daftar Notifikasi</h2>
        
        <button onclick="markRead()">Tandai Semua Dibaca</button>
        <div class="box-notif">
            <?php while ($row = $data->fetch_assoc()): ?>
            <?php if ($row['is_read'] == 0 ) :?>
                <div id="content-notifications" style="background: #2756ffff;">
                    <ul>
                        <li><small style="font-size: 12px;"><?= $row['created_at'] ?></small></li>
                        <li style=" font-weight: bold; font-size: 18px;"><?= $row['subject'] ?></li>
                        <li><?= $row['message'] ?></li>
                    </ul>
                </div>
                <?php else : ?>
                <div id="content-notifications" style="background: #f7faffff;">
                    <ul>
                        <li><small style="font-size: 12px; "><?= $row['created_at'] ?></small></li>
                        <li style=" font-weight: bold; font-size: 18px;"><?= $row['subject'] ?></li>
                        <li><?= $row['message'] ?></li>
                    </ul>
                </div>
                <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
</body>
        
<script>
function markRead() {
    fetch('mark_as_read.php')
        .then(() => {
            location.reload();
        });
}
</script>
