<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Handle image
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $target_dir = "../images/blog/";
        $imagePath = $target_dir . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
        $imagePath = 'images/blog/' . basename($image['name']);
    } else {
        $stmt_image = $pdo->prepare("SELECT image FROM blog WHERE id = :id");
        $stmt_image->execute(['id' => $id]);
        $blog = $stmt_image->fetch(PDO::FETCH_ASSOC);
        $imagePath = $blog['image'];
    }

    try {
        // Update the blog post including the image, category, and tags
        $stmt = $pdo->prepare("UPDATE blog SET title = :title, content = :content, category = :category, image = :image, tags = :tags WHERE id = :id");
        $stmt->execute(['title' => $title, 'content' => $content, 'category' => $category, 'image' => $imagePath, 'tags' => $tags, 'id' => $id]);
        header('Location: manage-blog.php?updated=success');
    } catch (Exception $e) {
        header('Location: manage-blog.php?updated=error');
    }
    exit;
}