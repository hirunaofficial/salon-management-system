<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    try {
        $stmt = $pdo->prepare("INSERT INTO blog (title, content, post_date, category) VALUES (:title, :content, CURDATE(), :category)");
        $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category]);
        header('Location: manage-blog.php?added=success');
    } catch (Exception $e) {
        header('Location: manage-blog.php?added=error');
    }
    exit;
}