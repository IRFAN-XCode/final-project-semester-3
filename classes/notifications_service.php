<?php
require_once __DIR__ . '/notifications_mailer.php';

class NotificationsService {

    private $db;
    private $mailer;

    public function __construct($db) {
        $this->db = $db;
        $this->mailer = new NotificationsMailer();
    }

    public function sendNotification($user_id, $email, $subject, $message) {

        $status = $this->mailer->send($email, $subject, $message)
                    ? 'sent'
                    : 'failed';

        $stmt = $this->db->prepare("
            INSERT INTO notifications (user_id, email, subject, message, status)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("issss", $user_id, $email, $subject, $message, $status);
        $stmt->execute();
    }
}
