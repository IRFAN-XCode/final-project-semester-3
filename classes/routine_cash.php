<?php
class RoutineCash {
    private $conn;
    private $table_name = "pengeluaran_rutin";

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create($user_id, $nama, $nominal, $tgl_jatuh_tempo, $frekuensi) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " (user_id, nama_pengeluaran, nominal, tgl_jatuh_tempo, frekuensi) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiss", $user_id, $nama, $nominal, $tgl_jatuh_tempo, $frekuensi);
        return $stmt->execute();
    }
    
    public function readAll($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY tgl_jatuh_tempo ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTransaksiById($id) {
        $query = "SELECT id_pr, nama_pengeluaran, nominal, tgl_jatuh_tempo, frekuensi 
              FROM pengeluaran_rutin WHERE id_pr = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
    }
    
    public function update($id, $nama, $nominal, $tgl_jatuh_tempo, $frekuensi) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET nama_pengeluaran = ?, nominal = ?, tgl_jatuh_tempo = ?, frekuensi = ? WHERE id_pr = ?");
        $stmt->bind_param("sissi", $nama, $nominal, $tgl_jatuh_tempo, $frekuensi, $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id_pr = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>