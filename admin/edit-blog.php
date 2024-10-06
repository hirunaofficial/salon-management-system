<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    try {
        $stmt = $pdo->prepare("UPDATE blog SET title = :title, content = :content, category = :category WHERE id = :id");
        $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category, 'id' => $id]);
        header('Location: manage-blog.php?updated=success');
    } catch (Exception $e) {
        header('Location: manage-blog.php?updated=error');
    }
    exit;
}