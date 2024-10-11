<?php
include '../dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Fetch the image path before deleting the blog
        $stmt_image = $pdo->prepare("SELECT image FROM blog WHERE id = :id");
        $stmt_image->execute(['id' => $id]);
        $blog = $stmt_image->fetch(PDO::FETCH_ASSOC);
        $imagePath = "../" . $blog['image'];

        // Delete the blog post
        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Delete the image from the server if it exists
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        header('Location: manage-blog.php?deleted=success');
    } catch (Exception $e) {
        header('Location: manage-blog.php?deleted=error');
    }
    exit;
}