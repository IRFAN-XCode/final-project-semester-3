<?php
class AnalyticService {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getMonthlySummary($id_user) {
        $bulan_ini = date('Y-m-01');
        $bulan_depan = date('Y-m-01', strtotime('+1 month'));

        $sql = "SELECT kategori, SUM(nominal_idr) AS total FROM transaksi WHERE user_id = ? GROUP BY kategori";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pemasukan = 0;
        $pengeluaran = 0;
        
        while ($row = $result->fetch_assoc()) {
            if ($row['kategori'] === 'Pemasukan') {
                $pemasukan = $row['total'];
            } else {
                $pengeluaran += $row['total'];
            }
        }
        
        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $pemasukan - $pengeluaran
        ];
    }
    
    public function analyzeSpendingCategories($id_user, $limit = 3) {
        $bulan_ini = date('Y-m-01');
        $bulan_depan = date('Y-m-01', strtotime('+1 month'));

        $sql = "SELECT kategori, SUM(nominal_idr) AS total FROM transaksi WHERE user_id = ? AND kategori != 'Pemasukan' AND tanggal >= ? AND tanggal < ? GROUP BY kategori ORDER BY total DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issi", $id_user, $bulan_ini, $bulan_depan, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $boros_categories = $result->fetch_all(MYSQLI_ASSOC);
        
        $rekomendasi = [];
        if (!empty($boros_categories)) {
            $kategori_boros_nama = $boros_categories[0]['kategori'];
            $rekomendasi[] = "Kategori " . $kategori_boros_nama . " adalah yang paling boros bulan ini. Coba buat anggaran khusus untuk kategori ini atau kurangi pengeluaran yang tidak perlu.";
        } else {
            $rekomendasi[] = "Belum ada data pengeluaran yang cukup untuk dianalisis.";
        }
        
        return [
            'boros_categories' => $boros_categories,
            'rekomendasi' => $rekomendasi
        ];
    }
    
    public function getMonthlyDataForChart($id_user, $months = 6) {
        $data_chart = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $start_date = date('Y-m-01', strtotime("-$i month"));
            $end_date = date('Y-m-01', strtotime("-" . ($i - 1) . " month"));
            $label = date('M Y', strtotime($start_date));
            
            $sql = "SELECT kategori, SUM(nominal_idr) AS total FROM transaksi WHERE user_id = ? AND tanggal >= ? AND tanggal < ? GROUP BY kategori";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iss", $id_user, $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();

            $pemasukan = 0;
            $pengeluaran = 0;

            while ($row = $result->fetch_assoc()) {
                if ($row['kategori'] === 'Pemasukan') {
                    $pemasukan = $row['total'];
                } else {
                    $pengeluaran += $row['total'];
                }
            }
            
            $data_chart[] = [
                'bulan' => $label,
                'pemasukan' => (int)$pemasukan,
                'pengeluaran' => (int)$pengeluaran
            ];
        }
        return $data_chart;
    }
}
?>