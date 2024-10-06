<?php
include '../dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = :id");
        $stmt->execute(['id' => $id]);
        header('Location: manage-blog.php?deleted=success');
    } catch (Exception $e) {
        header('Location: manage-blog.php?deleted=error');
    }
    exit;
}