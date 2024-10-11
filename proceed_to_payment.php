<?php
include 'dbconnect.php';
include 'header.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Function to send order confirmation email
function sendOrderConfirmationEmail($email, $orderDetails) {
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
        $mail->Subject = 'Order Payment Details - Glamour Salon';
        $mail->Body = $orderDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail Error: ' . $mail->ErrorInfo);
        return false;
    }
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed with payment.'); window.location.href = 'login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    echo "<script>alert('No order found.'); window.location.href = 'manage-orders.php';</script>";
    exit;
}

$order_id = $_GET['order_id'];

// Fetch the order details
$stmt_order = $pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id AND user_id = :user_id");
$stmt_order->execute(['order_id' => $order_id, 'user_id' => $user_id]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

if (!$order || $order['status'] !== 'unpaid') {
    echo "<script>alert('This order is not available for payment.'); window.location.href = 'manage-orders.php';</script>";
    exit;
}

// Fetch user details
$stmt_user = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt_user->execute(['user_id' => $user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Prepare the email content with full order details
$orderDetails = "<h2>Order Details</h2>";
$orderDetails .= "<p><strong>Order ID:</strong> {$order_id}</p>";
$orderDetails .= "<p><strong>Total Amount:</strong> LKR " . number_format($order['total'], 2) . "</p>";
$orderDetails .= "<p><strong>Payment Method:</strong> " . $order['payment_method'] . "</p>";
$orderDetails .= "<h3>Customer Information</h3>";
$orderDetails .= "<p><strong>Name:</strong> {$user['first_name']} {$user['last_name']}</p>";
$orderDetails .= "<p><strong>Email:</strong> {$user['email']}</p>";
$orderDetails .= "<p><strong>Telephone:</strong> {$user['telephone']}</p>";
$orderDetails .= "<p><strong>Address:</strong> {$user['address']}, {$user['city']}, {$user['postal_code']}, {$user['country']}</p>";

// Handle payment method logic
if ($order['payment_method'] === 'online_payment') {
    // Send email for online payment
    if (!sendOrderConfirmationEmail($user['email'], $orderDetails)) {
        echo "<script>alert('There was an error sending the confirmation email. Please check your email details.');</script>";
    }

    // Retrieve PayHere credentials and URLs from .env
    $merchant_id = $_ENV['PAYHERE_MERCHANT_ID'];
    $merchant_secret = $_ENV['PAYHERE_MERCHANT_SECRET'];
    $return_url = $_ENV['PAYHERE_RETURN_URL'];
    $cancel_url = $_ENV['PAYHERE_CANCEL_URL'];
    $notify_url = $_ENV['PAYHERE_NOTIFY_URL'];
    $currency = 'LKR';

    // Calculate the hash
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            number_format($order['total'], 2, '.', '') . 
            $currency .  
            strtoupper(md5($merchant_secret))
        )
    );

    // Prepare PayHere checkout form
    echo '<form method="post" action="https://sandbox.payhere.lk/pay/checkout" id="payhere_form">';
    echo '<input type="hidden" name="merchant_id" value="' . $merchant_id . '">';
    echo '<input type="hidden" name="return_url" value="' . $return_url . '">';
    echo '<input type="hidden" name="cancel_url" value="' . $cancel_url . '">';
    echo '<input type="hidden" name="notify_url" value="' . $notify_url . '">';
    echo '<input type="hidden" name="order_id" value="' . $order_id . '">';
    echo '<input type="hidden" name="items" value="Order No: ' . $order_id . '">';
    echo '<input type="hidden" name="currency" value="' . $currency . '">';
    echo '<input type="hidden" name="amount" value="' . number_format($order['total'], 2, '.', '') . '">';
    echo '<input type="hidden" name="first_name" value="' . $user['first_name'] . '">';
    echo '<input type="hidden" name="last_name" value="' . $user['last_name'] . '">';
    echo '<input type="hidden" name="email" value="' . $user['email'] . '">';
    echo '<input type="hidden" name="phone" value="' . $user['telephone'] . '">';
    echo '<input type="hidden" name="address" value="' . $user['address'] . '">';
    echo '<input type="hidden" name="city" value="' . $user['city'] . '">';
    echo '<input type="hidden" name="country" value="' . $user['country'] . '">';
    echo '<input type="hidden" name="hash" value="' . $hash . '">';
    echo '</form>';

    // Redirect to PayHere
    echo '<script>document.getElementById("payhere_form").submit();</script>';
    exit;

} elseif ($order['payment_method'] === 'cod') {
    // Handle Cash on Delivery (COD)
    echo "<script>alert('Your order is marked as Cash on Delivery. You will be contacted for delivery.'); window.location.href = 'manage-orders.php';</script>";
    exit;
}

?>

<section class="checkout-area ptb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="checkout-section">
                    <h4>Processing your order payment...</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>