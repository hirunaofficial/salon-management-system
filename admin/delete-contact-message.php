<?php
include '../dbconnect.php';

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = :id");
    $stmt->execute([':id' => $message_id]);

    if ($stmt->rowCount()) {
        echo "<script>alert('Message deleted successfully!'); window.location.href = 'contact-messages.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the message.'); window.location.href = 'contact-messages.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'contact-messages.php';</script>";
}
?>