<?php
include '../dbconnect.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        echo "<script>alert('Product deleted successfully!'); window.location.href = 'manage-products.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to delete product: " . $e->getMessage() . "'); window.location.href = 'manage-products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-products.php';</script>";
}