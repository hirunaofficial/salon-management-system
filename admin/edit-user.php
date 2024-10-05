<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("
            UPDATE users 
            SET first_name = :first_name, last_name = :last_name, email = :email, telephone = :telephone, role = :role 
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':telephone' => $telephone,
            ':role' => $role,
            ':user_id' => $user_id
        ]);
        echo "<script>alert('User updated successfully!'); window.location.href = 'manage-users.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to update user: " . $e->getMessage() . "'); window.location.href = 'manage-users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-users.php';</script>";
}
