<?php
include '../dbconnect.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendAppointmentUpdateEmail($email, $appointmentDetails) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_USER'], 'Salon Name');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Appointment Status Update';
        $mail->Body = $appointmentDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

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

    $stmt_appointment = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.appointment_time, s.name AS service_name, 
               CONCAT(u.first_name, ' ', u.last_name) AS customer_name, u.email
        FROM appointments a
        JOIN services s ON a.service_id = s.service_id
        JOIN users u ON a.user_id = u.user_id
        WHERE a.appointment_id = :appointment_id
    ");
    $stmt_appointment->execute(['appointment_id' => $appointment_id]);
    $appointment = $stmt_appointment->fetch(PDO::FETCH_ASSOC);

    $appointmentDetails = "<h2>Appointment Status Update</h2>";
    $appointmentDetails .= "<p>Dear {$appointment['customer_name']},</p>";
    $appointmentDetails .= "<p>Your appointment for <strong>{$appointment['service_name']}</strong> has been updated.</p>";
    $appointmentDetails .= "<p><strong>New Status:</strong> <span style='font-weight: bold; color: #5cb85c;'>" . ucfirst($status) . "</span></p>";
    $appointmentDetails .= "<p><strong>Date:</strong> " . date('F d, Y', strtotime($appointment['appointment_date'])) . "<br><strong>Time:</strong> " . date('h:i A', strtotime($appointment['appointment_time'])) . "</p>";
    $appointmentDetails .= "<p>If you have any questions, feel free to contact us.</p>";
    $appointmentDetails .= "<p>Thank you!</p>";

    sendAppointmentUpdateEmail($appointment['email'], $appointmentDetails);

    echo json_encode(['success' => true]);
    exit;
}