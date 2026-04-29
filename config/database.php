<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Tự động nhận diện môi trường
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1' || strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            // Cấu hình cho máy cá nhân (XAMPP)
            $this->host = "localhost";
            $this->db_name = "ban_truyen_tranh";
            $this->username = "root";
            $this->password = "123456";
        } else {
            // Cấu hình cho Hosting InfinityFree
            $this->host = "sql210.infinityfree.com"; 
            $this->db_name = "if0_41731555_ban_truyen_tranh";
            $this->username = "if0_41731555";
            $this->password = "gcQwCfcz8625";
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Set error mode
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            die("<h1>Lỗi kết nối Cơ sở dữ liệu!</h1><p>Chi tiết lỗi: " . $exception->getMessage() . "</p><p>Vui lòng kiểm tra lại thông tin cấu hình trong file <b>config/database.php</b></p>");
        }

        return $this->conn;
    }
}
?>
