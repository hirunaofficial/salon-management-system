<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password, telephone, role) 
            VALUES (:first_name, :last_name, :email, :password, :telephone, :role)
        ");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':password' => $password,
            ':telephone' => $telephone,
            ':role' => $role
        ]);
        echo "<script>alert('User added successfully!'); window.location.href = 'manage-users.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to add user: " . $e->getMessage() . "'); window.location.href = 'manage-users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-users.php';</script>";
}
