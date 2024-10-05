<?php
include '../dbconnect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        echo "<script>alert('User deleted successfully!'); window.location.href = 'manage-users.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to delete user: " . $e->getMessage() . "'); window.location.href = 'manage-users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-users.php';</script>";
}
