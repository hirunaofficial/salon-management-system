<?php
include '../dbconnect.php';

if (isset($_GET['blog_id'])) {
    $blog_id = $_GET['blog_id'];

    $stmt = $pdo->prepare("
        SELECT c.id, c.author, c.email, c.content, c.created_at, b.title 
        FROM comments c 
        JOIN blog b ON c.blog_id = b.id 
        WHERE c.blog_id = :blog_id
        ORDER BY c.created_at DESC
    ");
    $stmt->execute(['blog_id' => $blog_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($comments) {
        echo json_encode([
            'success' => true,
            'comments' => $comments
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No comments found.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Blog ID is missing.'
    ]);
}