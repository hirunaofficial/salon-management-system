<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $member_price = $_POST['member_price'];
    $duration = $_POST['duration'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO services (name, category, description, price, member_price, duration) 
            VALUES (:name, :category, :description, :price, :member_price, :duration)
        ");
        $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':description' => $description,
            ':price' => $price,
            ':member_price' => $member_price,
            ':duration' => $duration
        ]);
        echo "<script>alert('Service added successfully!'); window.location.href = 'manage-services.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to add service: " . $e->getMessage() . "'); window.location.href = 'manage-services.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-services.php';</script>";
}