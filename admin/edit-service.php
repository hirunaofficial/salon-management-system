<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = $_POST['service_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $member_price = $_POST['member_price'];
    $duration = $_POST['duration'];

    try {
        $stmt = $pdo->prepare("
            UPDATE services 
            SET name = :name, category = :category, description = :description, price = :price, member_price = :member_price, duration = :duration
            WHERE service_id = :service_id
        ");
        $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':price' => $price,
            ':member_price' => $member_price,
            ':duration' => $duration,
            ':service_id' => $service_id
        ]);
        echo "<script>alert('Service updated successfully!'); window.location.href = 'manage-services.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to update service: " . $e->getMessage() . "'); window.location.href = 'manage-services.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-services.php';</script>";
}