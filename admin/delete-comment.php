<?php
include '../dbconnect.php';

if (isset($_GET['id'])) {
    $comment_id = $_GET['id'];

    try {
        // Delete comment
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->execute(['id' => $comment_id]);
        header('Location: manage-comments.php?deleted=success');
    } catch (Exception $e) {
        header('Location: manage-comments.php?deleted=error');
    }
    exit;
}