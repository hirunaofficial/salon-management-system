<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $service_id = $_POST['service_id'];
    $staff_id = $_POST['staff_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $pdo->prepare("
        INSERT INTO appointments (user_id, service_id, staff_id, appointment_date, appointment_time)
        VALUES (:user_id, :service_id, :staff_id, :appointment_date, :appointment_time)
    ");
    
    $stmt->execute([
        'user_id' => $user_id,
        'service_id' => $service_id,
        'staff_id' => $staff_id,
        'appointment_date' => $appointment_date,
        'appointment_time' => $appointment_time
    ]);

    header('Location: manage-appointments.php');
    exit;
}
?>