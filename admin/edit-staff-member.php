<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];

    try {
        $stmt = $pdo->prepare("
            UPDATE staff 
            SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone, specialization = :specialization
            WHERE staff_id = :staff_id
        ");
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':phone' => $phone,
            ':specialization' => $specialization,
            ':staff_id' => $staff_id
        ]);
        echo "<script>alert('Staff member updated successfully!'); window.location.href = 'manage-staff-members.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to update staff member!'); window.location.href = 'manage-staff-members.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-staff-members.php';</script>";
}
?>