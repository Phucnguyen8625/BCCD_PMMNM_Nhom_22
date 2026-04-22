<?php
class Payment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPayments() {
        $stmt = $this->conn->prepare("SELECT p.*, o.customer_name FROM payments p JOIN orders o ON p.order_id = o.id ORDER BY p.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPaymentById($id) {
        $stmt = $this->conn->prepare("SELECT p.*, o.customer_name FROM payments p JOIN orders o ON p.order_id = o.id WHERE p.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPayment($order_id, $payment_method, $amount, $status, $transaction_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO payments (order_id, payment_method, amount, payment_status, transaction_id) VALUES (:order_id, :method, :amount, :status, :txn_id)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':method', $payment_method);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':txn_id', $transaction_id);
        return $stmt->execute();
    }

    public function updatePaymentStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE payments SET payment_status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateStatusByTxnRef($txnRef, $status, $gateway_txn_id = null) {
        $stmt = $this->conn->prepare("UPDATE payments SET payment_status = :status, transaction_id = :gateway_id WHERE transaction_id = :txn_ref");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':gateway_id', $gateway_txn_id);
        $stmt->bindParam(':txn_ref', $txnRef);
        return $stmt->execute();
    }
}
?>
