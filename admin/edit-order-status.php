<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
    $stmt->execute(['status' => $status, 'order_id' => $order_id]);

    echo "<script>alert('Order status updated successfully!'); window.location.href = 'manage-orders.php';</script>";
}
?>