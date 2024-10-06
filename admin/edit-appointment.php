<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $service_id = $_POST['service_id'];
    $staff_id = $_POST['staff_id'];

    $stmt = $pdo->prepare("
        UPDATE appointments 
        SET appointment_date = :appointment_date, 
            appointment_time = :appointment_time, 
            service_id = :service_id,
            staff_id = :staff_id
        WHERE appointment_id = :appointment_id
    ");
    
    $stmt->execute([
        'appointment_id' => $appointment_id,
        'appointment_date' => $appointment_date,
        'appointment_time' => $appointment_time,
        'service_id' => $service_id,
        'staff_id' => $staff_id
    ]);

    header('Location: manage-appointments.php');
    exit;
}
?>