<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer-master/src/SMTP.php';


class ForgotPasswordMailer {

    private $mail;

    public function __construct() {
        $config = require __DIR__ . '/../config/mail.php';

        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $config['host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $config['username'];
        $this->mail->Password = $config['password'];
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = $config['port'];

        $this->mail->setFrom($config['from_email'], $config['from_name']);
        $this->mail->isHTML(true);
    }

    public function sendResetLink($email, $link) {
        $this->mail->clearAllRecipients();
        $this->mail->addAddress($email);
        $this->mail->Subject = "Reset Password Akun Anda";

        $this->mail->Body = "
            <h3>Reset Password</h3>
            <p>Klik link di bawah ini untuk reset password:</p>
            <a href='$link'>$link</a>
            <p>Link berlaku 30 menit.</p>
        ";

        return $this->mail->send();
    }
}
