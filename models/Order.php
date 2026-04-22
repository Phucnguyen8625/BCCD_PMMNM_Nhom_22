<?php
class Order {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllOrders() {
        $stmt = $this->conn->prepare("SELECT * FROM orders ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($order_id) {
        $stmt = $this->conn->prepare("SELECT od.*, c.name as comic_name FROM order_details od JOIN comics c ON od.comic_id = c.id WHERE od.order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function createOrder($customer_name, $customer_phone, $customer_email, $address, $total_amount) {
        $stmt = $this->conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_email, address, total_amount) VALUES (:name, :phone, :email, :address, :total)");
        $stmt->bindParam(':name', $customer_name);
        $stmt->bindParam(':phone', $customer_phone);
        $stmt->bindParam(':email', $customer_email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':total', $total_amount);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function addOrderDetail($order_id, $comic_id, $quantity, $price) {
        $stmt = $this->conn->prepare("INSERT INTO order_details (order_id, comic_id, quantity, price) VALUES (:order_id, :comic_id, :quantity, :price)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':comic_id', $comic_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }
}
?>
