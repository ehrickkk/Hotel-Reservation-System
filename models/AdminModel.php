<?php
// models/AdminModel.php
require_once __DIR__ . '/Database.php';

class AdminModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function verifyLogin($username, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch();
                // Simple plain text password check as per assignment
                if ($password === $row['password']) {
                    return true;
                }
            }
            return false;
        } catch(PDOException $e) {
            // Throw exception to be caught by the controller
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }
}
?>
