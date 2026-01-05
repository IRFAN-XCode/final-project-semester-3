<style>
    :root {
        --bg-sidebar: linear-gradient(10deg, #023AFF, #0019FF);
        --bg-hover: #2756ffff;
        --bg-content: #111827;

        --text-main: #f7faffff;
        --text-muted: #f7faffff;
        --accent: #f7faffff;
        --danger: #da1d1dff;
    }
    .sidebar {
        width: 150px;
        height: 100vh;
        background: var(--bg-sidebar);
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
        transition: transform .3s ease;
        z-index: 1000;
    }
    .sidebar.hidden {
        transform: translateX(-100%);
    }
    
    .brand {
        width: 150px;
        height: 50px;
        background: white;
        margin-bottom: 15px;
        overflow: hidden;         
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .brand img {
        width: 100%;
        height: 100%;
        object-fit: cover;      
    }
    .menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-family: 'Segoe UI', sans-serif;
    }
    .menu a {
        text-decoration: none;
        padding: 12px 10px;
        border-radius: 6px;
        color: var(--text-muted);
        font-size: 0.95rem;
        transition: .2s;
    }
    .menu a:hover {
        background: var(--bg-hover);
        color: var(--accent);
    }
    .menu a.logout {
        color: var(--danger);
    }
    .menu a.logout:hover {
        color: white;
        background: #b91c1c;
    }
</style>
<div id="sidebar-overlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <img src="<?= BASE_URL ?>/assets/finance-care.jpg" alt="Logo Financial Care">
    </div>
    
    <nav class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="list_transaksi.php">Transaksi
        <a href="notifikasi.php" style="position:relative;">Notifikasi
    <span id="notif-badge"
        style="
            position:absolute;
            top:-8px;
            right:-10px;
            background:red;
            color:white;
            padding:2px 6px;
            border-radius:50%;
            font-size:12px;
        ">
    </span>
</a>

<script>
function loadNotif() {
    fetch('public/user/fetch_unread_notif.php')
        .then(res => res.text())
        .then(count => {
            if (count > 0) {
                document.getElementById('notif-badge').innerText = count;
            } else {
                document.getElementById('notif-badge').style.display = 'none';
            }
        });
}

setInterval(loadNotif, 3000); // cek setiap 3 detik
loadNotif();


document.addEventListener("DOMContentLoaded", function () {

    const sidebar  = document.getElementById('sidebar');
    const toggle   = document.getElementById('toggleSidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const body     = document.body;

    function isMobile() {
        return window.innerWidth <= 768;
    }

    // default mobile state
    if (isMobile()) {
        sidebar.classList.remove('hidden');
        body.classList.add('sidebar-hidden');
    }

    toggle.addEventListener('click', function () {

        if (isMobile()) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('hidden');
            body.classList.toggle('sidebar-hidden');
        }

    });

    // klik area luar = tutup sidebar
    overlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });

    // resize handler
    window.addEventListener('resize', function () {
        if (!isMobile()) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            body.classList.remove('sidebar-hidden');
        }
    });

});

</script>
        <a class="logout" href="/app-fp/logout.php">Logout</a>
    </nav>
</aside>