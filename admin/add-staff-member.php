<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO staff (first_name, last_name, email, phone, specialization) 
            VALUES (:first_name, :last_name, :email, :phone, :specialization)
        ");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':phone' => $phone,
            ':specialization' => $specialization
        ]);
        echo "<script>alert('Staff member added successfully!'); window.location.href = 'manage-staff-members.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to add staff member!'); window.location.href = 'manage-staff-members.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-staff-members.php';</script>";
}
?>