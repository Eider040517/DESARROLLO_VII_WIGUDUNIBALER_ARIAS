<?php
require_once __DIR__ . '/../../config.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function loginOrCreateUser($userInfo) {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (email, nombre, google_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE nombre = VALUES(nombre)");
        $stmt->bind_param("sss", $userInfo->email, $userInfo->name, $userInfo->id);
        $stmt->execute();
        $_SESSION['user_email'] = $userInfo->email;
        $_SESSION['user_name'] = $userInfo->name;
    }
}
?>
