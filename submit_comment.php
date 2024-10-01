<?php
include 'dbconnect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : 0;
    $author = isset($_POST['author']) ? trim($_POST['author']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    // Validate form data
    if ($blog_id > 0 && !empty($author) && !empty($email) && !empty($content)) {
        $stmt = $pdo->prepare("
            INSERT INTO comments (blog_id, author, email, content)
            VALUES (:blog_id, :author, :email, :content)
        ");
        $stmt->execute([
            'blog_id' => $blog_id,
            'author' => $author,
            'email' => $email,
            'content' => $content,
        ]);

        header("Location: blog-details.php?id=$blog_id&comment=success");
        exit;
    } else {
        header("Location: blog-details.php?id=$blog_id&comment=error");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}