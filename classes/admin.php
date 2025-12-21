<?php

class Admin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = "SELECT id, nim, username, Email, Program_studi FROM profil WHERE role = 'mahasiswa' ORDER BY username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function updateUser($id, $nim, $username, $email, $prodi) {
        $query = "UPDATE profil SET nim = ?, username = ?, Email = ?, Program_studi = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $nim, $username, $email, $prodi, $id);
        
        return $stmt->execute();
    }

    public function getUserById($id) {
        $query = "SELECT id, nim, username, Email, Program_studi 
                  FROM profil WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM profil WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}