<?php
include '../dbconnect.php';

if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM services WHERE service_id = :service_id");
        $stmt->execute([':service_id' => $service_id]);
        echo "<script>alert('Service deleted successfully!'); window.location.href = 'manage-services.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to delete service: " . $e->getMessage() . "'); window.location.href = 'manage-services.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-services.php';</script>";
}