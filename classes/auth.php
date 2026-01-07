<?php
class Auth {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nim, $username, $email, $prodi, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

        $stmt = $this->conn->prepare("INSERT INTO profil (nim, username, email, program_studi, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nim, $username, $email, $prodi, $hashed_password);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, password, role FROM profil WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) { 
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }
        return false;
    }
}
?>