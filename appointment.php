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

// Function to send email after successful booking
function sendAppointmentEmail($email, $name, $appointment_date, $appointment_time, $service_name) {
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
        $mail->Subject = 'Your Appointment Confirmation';
        $mail->Body = "Dear $name,<br><br>Your appointment for $service_name on <b>$appointment_date</b> at <b>$appointment_time</b> has been successfully booked.<br><br>We look forward to seeing you at Glamour Salon.<br><br>Best regards,<br>Glamour Salon Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to assign a random staff member if not selected
function assignRandomStaff($pdo, $appointment_date, $appointment_time, $service_duration) {
    // Get a random staff member who is available for the selected time and date
    $stmt_random_staff = $pdo->prepare("
        SELECT user_id 
        FROM users 
        WHERE role = 'staff'
        AND user_id NOT IN (
            SELECT staff_id FROM appointments 
            WHERE appointment_date = :appointment_date 
            AND (
                :appointment_start_time BETWEEN appointment_time AND ADDTIME(appointment_time, SEC_TO_TIME(:service_duration * 60))
                OR 
                ADDTIME(:appointment_start_time, SEC_TO_TIME(:service_duration * 60)) BETWEEN appointment_time AND ADDTIME(appointment_time, SEC_TO_TIME(:service_duration * 60))
            )
        )
        ORDER BY RAND() LIMIT 1
    ");
    $stmt_random_staff->execute([
        'appointment_date' => $appointment_date,
        'appointment_start_time' => $appointment_time,
        'service_duration' => $service_duration
    ]);

    $staff = $stmt_random_staff->fetch(PDO::FETCH_ASSOC);
    return $staff ? $staff['user_id'] : null;
}

// Function to check if the selected staff is available
function isStaffAvailable($pdo, $staff_id, $appointment_date, $appointment_time, $service_duration) {
    $stmt_check = $pdo->prepare("
        SELECT COUNT(*) as appointment_count 
        FROM appointments 
        WHERE staff_id = :staff_id 
        AND appointment_date = :appointment_date 
        AND (
            :appointment_start_time BETWEEN appointment_time AND ADDTIME(appointment_time, SEC_TO_TIME(:service_duration * 60))
            OR 
            ADDTIME(:appointment_start_time, SEC_TO_TIME(:service_duration * 60)) BETWEEN appointment_time AND ADDTIME(appointment_time, SEC_TO_TIME(:service_duration * 60))
        )
    ");
    $stmt_check->execute([
        'staff_id' => $staff_id,
        'appointment_date' => $appointment_date,
        'appointment_start_time' => $appointment_time,
        'service_duration' => $service_duration
    ]);

    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
    return $result['appointment_count'] == 0;
}

// Form submission logic
$message = '';
$message_type = ''; // Variable to store message type (success or danger)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_id = $_POST['service'];
    
    // Convert the user input date (assumed to be in dd/mm/yyyy) to the required format Y-m-d
    $input_date = $_POST['date'];
    $date_object = DateTime::createFromFormat('d/m/Y', $input_date);
    if ($date_object === false) {
        $message = "Invalid date format. Please use dd/mm/yyyy.";
        $message_type = 'danger';
    } else {
        $appointment_date = $date_object->format('Y-m-d');
    }

    $appointment_time = date('H:i:s', strtotime($_POST['time']));

    // Get the service duration from the services table
    $stmt_service = $pdo->prepare("SELECT name, duration FROM services WHERE service_id = :service_id");
    $stmt_service->execute(['service_id' => $service_id]);
    $service = $stmt_service->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        $message = "Invalid service selected.";
        $message_type = 'danger';
    } else {
        // Calculate appointment end time based on service duration
        $service_duration = $service['duration'];
        $service_name = $service['name'];
        
        // Check if the user selected a staff member
        $staff_id = isset($_POST['staff']) && !empty($_POST['staff']) ? $_POST['staff'] : assignRandomStaff($pdo, $appointment_date, $appointment_time, $service_duration); // Assign a random staff member if none selected
        
        if (!$staff_id) {
            $message = "Sorry, no staff member is available for the selected time.";
            $message_type = 'danger';
        } elseif (!isStaffAvailable($pdo, $staff_id, $appointment_date, $appointment_time, $service_duration)) {
            $message = "Sorry, the selected staff member is not available for this time slot.";
            $message_type = 'danger';
        } else {
            // Insert appointment into the database
            $stmt = $pdo->prepare("
                INSERT INTO appointments (user_id, name, email, phone, service_id, staff_id, appointment_date, appointment_time) 
                VALUES (:user_id, :name, :email, :phone, :service_id, :staff_id, :appointment_date, :appointment_time)
            ");
            $stmt->execute([
                'user_id' => $user_id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'service_id' => $service_id,
                'staff_id' => $staff_id,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time
            ]);

            // Send email after successful appointment booking
            if (sendAppointmentEmail($email, $name, $appointment_date, $appointment_time, $service_name)) {
                $message = "Appointment successfully booked and confirmation email sent!";
            } else {
                $message = "Appointment booked, but failed to send confirmation email.";
            }
            $message_type = 'success';
        }
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
                                <input type="text" name="name" value="<?= $user['first_name'] . ' ' . $user['last_name'] ?>" required disabled>
                                <input type="email" name="email" value="<?= $user['email'] ?>" required disabled>
                            </div>
                            <div class="input-box">
                                <input type="tel" name="phone" value="<?= $user['telephone'] ?>" required disabled>
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
                            <div style="border: 1px solid transparent; color: #000000; font-family: Lato; font-size: 14px; font-weight: 400; padding-left: 0px; line-height: 45px; margin-top: 18px;">
                                <select name="staff" style="border: 1px solid #000000; width: 100%; height: 45px; padding-left: 20px;">
                                    <option value="">Select Staff Member (Optional)</option>
                                    <?php
                                    $stmt_staff = $pdo->prepare("SELECT user_id, CONCAT(first_name, ' ', last_name) as staff_name FROM users WHERE role = 'staff'");
                                    $stmt_staff->execute();
                                    $staff_members = $stmt_staff->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($staff_members as $staff): ?>
                                        <option value="<?= $staff['user_id'] ?>"><?= $staff['staff_name'] ?></option>
                                    <?php endforeach; ?>
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