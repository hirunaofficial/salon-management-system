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

// Fetch the logged-in user's data
$user_id = $_SESSION['user_id'];
$stmt_user = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt_user->execute(['user_id' => $user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Function to check if the appointment slot is available (max 4 clients per time slot)
function checkExistingAppointments($pdo, $appointment_date, $appointment_time) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as appointment_count 
        FROM appointments 
        WHERE appointment_date = :appointment_date 
          AND appointment_time = :appointment_time
    ");
    $stmt->execute([
        'appointment_date' => $appointment_date,
        'appointment_time' => $appointment_time
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['appointment_count'] >= 4;
}

// Form submission logic
$message = '';
$message_type = ''; // Variable to store message type (success or danger)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_id = $_POST['service'];
    $appointment_date = date('Y-m-d', strtotime($_POST['date']));
    $appointment_time = date('H:i:s', strtotime($_POST['time']));

    // Check if the appointment slot is full
    if (checkExistingAppointments($pdo, $appointment_date, $appointment_time)) {
        $message = "Sorry, the selected time slot is fully booked.";
        $message_type = 'danger';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO appointments (user_id, name, email, phone, service_id, appointment_date, appointment_time) 
            VALUES (:user_id, :name, :email, :phone, :service_id, :appointment_date, :appointment_time)
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service_id' => $service_id,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time
        ]);

        $message = "Appointment successfully booked!";
        $message_type = 'success';
    }
}
?>

<section class="breadcrumbs-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Appointment</h2>
                    <ul>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                        <li>Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hs-appoinment-area" class="hs-appoinment-area bg-gray">
    <div class="container-fluid ps-0 pe-0">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6">
                <div class="appoinment-thumb appoinment-thumb-st2">
                    <img src="images/others/appoinment/1.jpg" alt="appointment image">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="appoinment-inner appoinment-inner-st2">
                    <div class="appoinment-title text-center">
                        <h2 class="section-title">Book an Appointment</h2>
                        <p class="section-details appoinment">
                            Schedule your beauty experience with Glamour Salon. Fill in the details below and we will take care of the rest.
                        </p>
                    </div>

                    <?php if ($message): ?>
                        <br>
                        <div class="alert alert-<?= $message_type ?> text-center">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <div class="appoinment-form mt-40">
                        <form action="appointment.php" method="POST">
                            <div class="input-box">
                                <input type="text" name="name" value="<?= $user['first_name'] . ' ' . $user['last_name'] ?>">
                                <input type="email" name="email" value="<?= $user['email'] ?>">
                            </div>
                            <div class="input-box">
                                <input type="tel" name="phone" value="<?= $user['telephone'] ?>">
                                <select name="service" required>
                                    <option disabled selected>Choose Service</option>
                                    <?php
                                    $stmt_services = $pdo->prepare("SELECT service_id, name FROM services");
                                    $stmt_services->execute();
                                    $services = $stmt_services->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($services as $service): ?>
                                        <option value="<?= $service['service_id'] ?>"><?= $service['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-box">
                                <input type="text" id="datepicker" name="date" placeholder="Preferred Date" required>
                                <select name="time" id="time-select" required>
                                    <option disabled selected>Choose Time</option>
                                </select>
                            </div>
                            <div class="book-appoin-btn mt-30">
                                <button type="submit" class="hs-btn hs-btn-2">Book Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>