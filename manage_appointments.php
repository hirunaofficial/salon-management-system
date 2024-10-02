<?php
include 'header.php';
include 'dbconnect.php';

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

    // Delete the appointment from the database
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE appointment_id = :appointment_id AND user_id = :user_id");
    $stmt->execute([
        'appointment_id' => $appointment_id,
        'user_id' => $user_id
    ]);

    $message = 'Appointment successfully canceled.';
}

// Fetch user's appointments from the database, including staff information
$stmt = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, s.name AS service_name, 
           CONCAT(st.first_name, ' ', st.last_name) AS staff_name
    FROM appointments a
    JOIN services s ON a.service_id = s.service_id
    LEFT JOIN staff st ON a.staff_id = st.staff_id
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($appointments as $appointment): ?>
                                    <tr>
                                        <td><?= $appointment['service_name'] ?></td>
                                        <td><?= $appointment['staff_name'] ?? 'N/A' ?></td> <!-- Staff info, or 'N/A' if null -->
                                        <td><?= date('F d, Y', strtotime($appointment['appointment_date'])) ?></td>
                                        <td><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                                        <td>
                                            <a href="?cancel_appointment=<?= $appointment['appointment_id'] ?>" 
                                               onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                               <button class="btn btn-primary ce5" type="submit" name="update_info">Cancel Appointment</button>
                                            </a>
                                            
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