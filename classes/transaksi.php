<?php
class Transaksi {
    private $conn;
    private $table_name = "transaksi";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($id_user, $nama, $nominal, $kategori, $tanggal, $keterangan) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " (id_user, nama_transaksi, nominal_transaksi, kategori, tanggal, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdsss", $id_user, $nama, $nominal, $kategori, $tanggal, $keterangan);
        return $stmt->execute();
    }
    
    public function readAll($id_user) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY tanggal DESC");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>