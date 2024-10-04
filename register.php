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

// Function to send OTP
function sendOTP($email, $otp) {
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
        $mail->Subject = 'Your OTP for Glamour Salon Account Verification';
        $mail->Body = "Dear Customer,<br><br>Your OTP for verifying your Glamour Salon account is: <b>$otp</b>.<br><br>This OTP will expire in 10 minutes.<br><br>Thank you for choosing Glamour Salon!<br><br>Best regards,<br>Glamour Salon Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle registration submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];

    // Check if the email already exists in users table
    $stmt_users = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt_users->execute(['email' => $email]);
    $existing_user = $stmt_users->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        $message = "An account with this email already exists.";
        $message_type = 'danger';
    } else {
        // Generate OTP
        $otp_code = rand(100000, 999999);
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Check if email already exists in user_otp
        $stmt_check_otp = $pdo->prepare("SELECT * FROM user_otp WHERE email = :email");
        $stmt_check_otp->execute(['email' => $email]);
        $existing_otp_entry = $stmt_check_otp->fetch(PDO::FETCH_ASSOC);

        if ($existing_otp_entry) {
            // Update the existing OTP record with new data
            $stmt_update_otp = $pdo->prepare("
                UPDATE user_otp 
                SET first_name = :first_name, last_name = :last_name, password = :password, telephone = :telephone, otp_code = :otp_code, otp_expiry = :otp_expiry 
                WHERE email = :email
            ");
            $stmt_update_otp->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'telephone' => $telephone,
                'otp_code' => $otp_code,
                'otp_expiry' => $otp_expiry
            ]);
        } else {
            // Insert new OTP record
            $stmt_otp = $pdo->prepare("
                INSERT INTO user_otp (first_name, last_name, email, password, telephone, otp_code, otp_expiry) 
                VALUES (:first_name, :last_name, :email, :password, :telephone, :otp_code, :otp_expiry)
            ");
            $stmt_otp->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'telephone' => $telephone,
                'otp_code' => $otp_code,
                'otp_expiry' => $otp_expiry
            ]);
        }

        // Send OTP via email
        if (sendOTP($email, $otp_code)) {
            echo "<script type='text/javascript'>
                    alert('OTP sent to your email. Please check your inbox.');
                    window.location.href = 'verify.php?email=$email';
                  </script>";
        } else {
            $message = "Failed to send OTP. Please try again.";
            $message_type = 'danger';
        }
    }
}
?>

<section class="register-area ptb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-content">
                    <h2 class="text-center">Create your account</h2>

                    <?php if (isset($message)): ?>
                        <div class="mt-20 alert alert-<?= $message_type ?>"><?= $message ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" required placeholder="Enter your first name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" required placeholder="Enter your last name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="tel" class="form-control" name="telephone" required placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="register" class="btn btn-primary btn-block mb-10">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #000000;
    border-radius: 4px;
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #000000;
    border: none;
    padding: 12px;
    font-size: 16px;
    width: 100%;
}

.btn-primary:hover {
    background-color: #000000;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}
</style>

<?php include 'footer.php'; ?>