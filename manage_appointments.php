<?php
include 'header.php';
include 'dbconnect.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Function to send cancellation email for appointments
function sendCancellationEmail($email, $appointmentDetails) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_USER'], 'Glamour Salon');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Glamour Salon: Appointment Cancellation Confirmation';
        $mail->Body = $appointmentDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Start session and check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script type='text/javascript'>
        window.location.href = 'login.php';
        </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle cancel appointment action
if (isset($_GET['cancel_appointment'])) {
    $appointment_id = $_GET['cancel_appointment'];

    // Fetch appointment details before deleting for the email
    $stmt_appointment = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.appointment_time, s.name AS service_name, 
               CONCAT(u_staff.first_name, ' ', u_staff.last_name) AS staff_name, u.email, u.first_name, u.last_name
        FROM appointments a
        JOIN services s ON a.service_id = s.service_id
        LEFT JOIN users u_staff ON a.staff_id = u_staff.user_id AND u_staff.role = 'staff'
        JOIN users u ON a.user_id = u.user_id
        WHERE a.appointment_id = :appointment_id AND a.user_id = :user_id
    ");
    $stmt_appointment->execute([
        'appointment_id' => $appointment_id,
        'user_id' => $user_id
    ]);

    $appointment = $stmt_appointment->fetch(PDO::FETCH_ASSOC);

    // Delete the appointment from the database
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id = :appointment_id AND user_id = :user_id");
    $stmt->execute([
        'appointment_id' => $appointment_id,
        'user_id' => $user_id
    ]);

    $message = 'Appointment successfully canceled.';

    // Prepare the cancellation email content
    $appointmentDetails = "<h2>Appointment Cancellation</h2>";
    $appointmentDetails .= "<p>Dear {$appointment['first_name']} {$appointment['last_name']},</p>";
    $appointmentDetails .= "<p>Your appointment for the service <strong>{$appointment['service_name']}</strong> with staff <strong>{$appointment['staff_name']}</strong> at Glamour Salon has been canceled.</p>";
    $appointmentDetails .= "<p>Date: " . date('F d, Y', strtotime($appointment['appointment_date'])) . "<br>Time: " . date('h:i A', strtotime($appointment['appointment_time'])) . "</p>";
    
    // Send cancellation email
    sendCancellationEmail($appointment['email'], $appointmentDetails);
}

// Fetch user's appointments from the database, including staff information and status
$stmt = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.status, s.name AS service_name, 
           CONCAT(u_staff.first_name, ' ', u_staff.last_name) AS staff_name
    FROM appointments a
    JOIN services s ON a.service_id = s.service_id
    LEFT JOIN users u_staff ON a.staff_id = u_staff.user_id AND u_staff.role = 'staff'
    WHERE a.user_id = :user_id
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt->execute(['user_id' => $user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Appointments</h2>
                    <ul>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                        <li>Manage Appointments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="manage-appointments-area pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="appointments-table">
                    <?php if (isset($message)): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>

                    <?php if (!empty($appointments)): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Staff</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?= $appointment['service_name'] ?></td>
                                        <td><?= $appointment['staff_name'] ?? 'N/A' ?></td>
                                        <td><?= date('F d, Y', strtotime($appointment['appointment_date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                                        <td><?= ucfirst($appointment['status']) ?></td>
                                        <td>
                                            <?php 
                                                $appointment_datetime = strtotime($appointment['appointment_date'] . ' ' . $appointment['appointment_time']);
                                                $current_datetime = time();
                                                
                                                if ($current_datetime < ($appointment_datetime - 86400)): ?>
                                                <a href="?cancel_appointment=<?= $appointment['appointment_id'] ?>" 
                                                   onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                   <button class="btn btn-primary ce5">Cancel Appointment</button>
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-primary ce5" disabled>Cancel Unavailable</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="text-align: center; font-size: 16px; color: #555; padding: 20px;">You have no upcoming appointments.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>