<?php
include '../dbconnect.php';

if (isset($_GET['staff_id'])) {
    $staff_id = $_GET['staff_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM staff WHERE staff_id = :staff_id");
        $stmt->execute([':staff_id' => $staff_id]);
        echo "<script>alert('Staff member deleted successfully!'); window.location.href = 'manage-staff-members.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to delete staff member!'); window.location.href = 'manage-staff-members.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-staff-members.php';</script>";
}
?>