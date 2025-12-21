<?php
require_once __DIR__ . '/ForgotPasswordMailer.php';

class ForgotPasswordService {

    private $db;
    private $mailer;

    public function __construct($db) {
        $this->db = $db;
        $this->mailer = new ForgotPasswordMailer();
    }

    public function requestReset($email) {
        $q = mysqli_query($this->db, "SELECT id FROM profil WHERE Email = '$email'");
        if (mysqli_num_rows($q) !== 1) return;

        $user = mysqli_fetch_assoc($q);
        $user_id = $user['id'];

        $token = bin2hex(random_bytes(32));

        mysqli_query($this->db, "INSERT INTO password_resets (user_id, token, expired_at)
        VALUES ($user_id, '$token', DATE_ADD(NOW(), INTERVAL 1 HOUR))");

        $link = "http://localhost/app-fp/public/user/reset_password.php?token=$token";

        $this->mailer->sendResetLink($email, $link);
    }

    public function resetPassword($token, $newPassword) {

        $token = trim($token);

        $q = mysqli_query($this->db,
            "SELECT * FROM password_resets 
             WHERE token = '$token' 
             AND expired_at > NOW()");

        if (mysqli_num_rows($q) !== 1) return false;

        $data = mysqli_fetch_assoc($q);
        $user_id = $data['user_id'];

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        mysqli_query($this->db,
            "UPDATE profil SET password = '$hash' WHERE id = $user_id");

        mysqli_query($this->db,
            "DELETE FROM password_resets WHERE user_id = $user_id");

        return true;
}
}
