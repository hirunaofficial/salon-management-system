<?php
include '../dbconnect.php';

if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id = :appointment_id");
    $stmt->execute(['appointment_id' => $appointment_id]);

    header('Location: manage-appointments.php');
    exit;
}
?>