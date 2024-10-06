<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("
        UPDATE appointments 
        SET status = :status 
        WHERE appointment_id = :appointment_id
    ");
    
    $stmt->execute([
        'appointment_id' => $appointment_id,
        'status' => $status
    ]);

    echo json_encode(['success' => true]);
    exit;
}
?>