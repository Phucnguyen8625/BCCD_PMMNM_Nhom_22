<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;
    private $table = 'users';

    public $id;
    public $full_name;
    public $username;
    public $email;
    public $password;
    public $role;
    public $status;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Tìm user theo username hoặc email
     */
    public function findByLoginValue($loginValue) {
        $query = "SELECT * FROM {$this->table} WHERE (username = :val OR email = :val) AND status = 'active' LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':val', $loginValue);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm user theo username (kiểm tra trùng khi đăng ký)
     */
    public function usernameExists($username) {
        $query = "SELECT id FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Tìm user theo email (kiểm tra trùng khi đăng ký)
     */
    public function emailExists($email) {
        $query = "SELECT id FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Đăng ký tài khoản mới
     */
    public function register($full_name, $username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO {$this->table} (full_name, username, email, password, role, status)
                  VALUES (:full_name, :username, :email, :password, 'user', 'active')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // --- ADMIN METHODS ---

    public function readAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRole($id, $role) {
        $query = "UPDATE {$this->table} SET role = :role WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function toggleStatus($id) {
        $user = $this->findById($id);
        if (!$user) return false;
        
        $newStatus = ($user['status'] === 'active') ? 'banned' : 'active';
        $query = "UPDATE {$this->table} SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
