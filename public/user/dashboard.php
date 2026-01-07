<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../sidebar.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../classes/analytic.php';
require_once __DIR__ . '/../../classes/routine_cash.php';

$id_user = $_SESSION['user_id'];
$analytic_service = new AnalyticService($conn);
$routine_cash = new RoutineCash($conn);

// 1. Dapatkan Ringkasan
$summary = $analytic_service->getMonthlySummary($id_user); 

// 2. Dapatkan Analisis dan Rekomendasi
$analysis = $analytic_service->analyzeSpendingCategories($id_user);

// 3. Dapatkan Daftar Pengeluaran Rutin
$rutin_list = $routine_cash->readAll($id_user);

// 4. Dapatkan Data untuk Grafik
$chart_data = $analytic_service->getMonthlyDataForChart($id_user, 6); 

// Grafik: pemasukan & pengeluaran bulanan - Time-series
$labels = array_column($chart_data, 'bulan');
$pemasukan_data = array_column($chart_data, 'pemasukan');
$pengeluaran_data = array_column($chart_data, 'pengeluaran');

// Grafik Kategori Boros - Bar
$kategori_labels = array_column($analysis['boros_categories'], 'kategori');
$kategori_data = array_column($analysis['boros_categories'], 'total');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Keuangan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../../assets/user_style.css"> 

</head>
<body>
    <header class="top-header">
        <button id="toggleSidebar" class="hamburger">☰</button>
        <img src="<?= BASE_URL ?>/assets/finance-care2.jpg" alt="Logo Financial Care">
    </header>

    <h2 style="font-size: 40px;">Dashboard</h2>
    <h2 style="font-size: 20px;">Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <div id="dashboard-container">
    
    <div class="card-container">
        <div id="total" class="card-box-section">
            <p>Saldo Bersih: <br>
            <b style="font-size: 25px;">Rp <?= number_format($summary['saldo'], 0, ',', '.') ?></b></p>
        </div>
        <div id="masuk"class="card-box-section">
            <p>Pemasukan: <br>
            <b style="font-size: 25px;">Rp <?= number_format($summary['pemasukan'], 0, ',', '.') ?></b></p>
        </div>
        <div id="keluar"class="card-box-section">
            <p>Pengeluaran: <br>
            <b style="font-size: 25px;" >Rp <?= number_format($summary['pengeluaran'], 0, ',', '.') ?></b></p>
        </div>
    </div>

        <div id="tagihan-dashboard">
            <h3>Daftar Tagihan</h3>
            <?php if (!empty($rutin_list)): ?>
                <a class="link" href="tambah_tagihan.php">Tambah</a>.
                <?php foreach ($rutin_list as $rutin): ?>
                    <p>
                    <a href="edit_tagihan.php?id=<?= $rutin['id_pr'] ?>">Edit</a>
                    <a href="hapus_tagihan.php?id=<?= $rutin['id_pr'] ?>" onclick=" return confirm
                            ('Hapus tagihan ini?');">Hapus</a><br>
                    <b><?= htmlspecialchars($rutin['nama_pengeluaran']) ?></b> 
                    (Rp <?= number_format($rutin['nominal'], 0, ',', '.') ?>)
                    <br>Jatuh Tempo: <b><?= htmlspecialchars($rutin['tgl_jatuh_tempo']) ?></b>
                    </p>
            <?php endforeach; ?>
        <?php else: ?>
            <a class="link" href="tambah_tagihan.php">Tambahkan sekarang</a>.
            <p style="text-align: center; color: #fa0e0eff; font-style: italic;">Belum ada tagihan. 
            </p>
        <?php endif; ?>
        </div>
        
        <div id="grafik-container" >        
            <div id="grafik-dashboard">
            <h3 class="section-title">Arus Kas Bulanan</h3>
            <canvas id="arusKasChart"></canvas>
            
            <script>
                const ctxArusKas = document.getElementById('arusKasChart');
                new Chart(ctxArusKas, {
                    type: 'line',
                    data: {
                        labels: <?= json_encode($labels) ?>,
                        datasets: [{
                        label: 'Pemasukan',
                        data: <?= json_encode($pemasukan_data) ?>,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }, {
                        label: 'Pengeluaran',
                        data: <?= json_encode($pengeluaran_data) ?>,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    }]
                }
            });
            </script>
            </div>

            <div id="bar-grafik-dashboard">
            <h3 class="section-title">Pengeluaran Berdasarkan Kategori</h3>

            <canvas id="kategoriBorosChart"></canvas>
            <script>
                const ctxKategoriBoros = document.getElementById('kategoriBorosChart');
                new Chart(ctxKategoriBoros, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode($kategori_labels) ?>,
                        datasets: [{
                            data: <?= json_encode($kategori_data) ?>,
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                        }]
                    }
                });
                </script>

            <h4 class="section-title">Rekomendasi Hemat:</h4>
            <ul>
                <?php foreach ($analysis['rekomendasi'] as $rekom): ?>
                    <li><?= $rekom ?></li>
                <?php endforeach; ?>
            </ul>
            </div>
        </div>
    </div>
</body>
</html>
