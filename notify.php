<?php
include 'dbconnect.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Function to send order status email
function sendOrderStatusEmail($email, $subject, $orderDetails) {
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
        $mail->Subject = $subject;
        $mail->Body = $orderDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mail Error: ' . $mail->ErrorInfo);
        return false;
    }
}

// Fetch the POST parameters from PayHere and sanitize input
$merchant_id = filter_input(INPUT_POST, 'merchant_id', FILTER_SANITIZE_STRING);
$order_id = filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_NUMBER_INT);
$payhere_amount = filter_input(INPUT_POST, 'payhere_amount', FILTER_SANITIZE_STRING);
$payhere_currency = filter_input(INPUT_POST, 'payhere_currency', FILTER_SANITIZE_STRING);
$status_code = filter_input(INPUT_POST, 'status_code', FILTER_SANITIZE_NUMBER_INT);
$md5sig = filter_input(INPUT_POST, 'md5sig', FILTER_SANITIZE_STRING);

// Your Merchant Secret (from .env)
$merchant_secret = $_ENV['PAYHERE_MERCHANT_SECRET'];

// Generate the local MD5 signature for verification
$local_md5sig = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        $payhere_amount . 
        $payhere_currency . 
        $status_code . 
        strtoupper(md5($merchant_secret))
    )
);

// Verify the payment notification
if ($local_md5sig === $md5sig) {
    $stmt_order = $pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $stmt_order->execute(['order_id' => $order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        error_log("Order not found for order ID: {$order_id}");
        return;
    }

    $stmt_items = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
    $stmt_items->execute(['order_id' => $order_id]);
    $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

    $orderDetails = "<h2>Order Details</h2>";
    $orderDetails .= "<p><strong>Order ID:</strong> {$order['order_id']}</p>";
    $orderDetails .= "<p><strong>Name:</strong> {$order['first_name']} {$order['last_name']}</p>";
    $orderDetails .= "<p><strong>Email:</strong> {$order['email']}</p>";
    $orderDetails .= "<p><strong>Telephone:</strong> {$order['telephone']}</p>";
    $orderDetails .= "<p><strong>Shipping Address:</strong> {$order['address']}, {$order['city']}, {$order['postal_code']}, {$order['country']}</p>";
    $orderDetails .= "<p><strong>Total Amount:</strong> LKR " . number_format($order['total'], 2) . "</p>";
    $orderDetails .= "<h3>Order Items:</h3><ul>";

    foreach ($order_items as $item) {
        $orderDetails .= "<li>{$item['product_name']} - Qty: {$item['quantity']} - Price: LKR " . number_format($item['price'], 2) . "</li>";
    }

    $orderDetails .= "</ul>";

    // Handle payment status codes and email content based on status
    switch ($status_code) {
        case 2: // Payment successful
            $stmt_update = $pdo->prepare("UPDATE orders SET status = 'paid' WHERE order_id = :order_id");
            $stmt_update->execute(['order_id' => $order_id]);
            $orderDetails .= "<p><strong>Payment Status:</strong> Successful</p>";
            $orderDetails .= "<p>Your payment has been received successfully. Thank you for shopping with Glamour Salon!</p>";
            sendOrderStatusEmail($order['email'], 'Order Completed - Glamour Salon', $orderDetails);
            error_log("Payment success for order ID: {$order_id}. Email sent.");
            break;

        case 0: // Payment pending
            $stmt_update = $pdo->prepare("UPDATE orders SET status = 'pending' WHERE order_id = :order_id");
            $stmt_update->execute(['order_id' => $order_id]);
            $orderDetails .= "<p><strong>Payment Status:</strong> Pending</p>";
            $orderDetails .= "<p>Your payment is currently pending. We will notify you once it has been processed. If you have any questions, please contact support.</p>";
            sendOrderStatusEmail($order['email'], 'Order Pending - Glamour Salon', $orderDetails);
            error_log("Payment pending for order ID: {$order_id}. Email sent.");
            break;

        case -1: // Payment canceled
            $stmt_update = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE order_id = :order_id");
            $stmt_update->execute(['order_id' => $order_id]);
            $orderDetails .= "<p><strong>Payment Status:</strong> Cancelled</p>";
            $orderDetails .= "<p>Your payment was cancelled. If you wish to retry, please place a new order. For any queries, contact support.</p>";
            sendOrderStatusEmail($order['email'], 'Order Cancelled - Glamour Salon', $orderDetails);
            error_log("Payment cancelled for order ID: {$order_id}. Email sent.");
            break;

        case -2: // Payment failed
            $stmt_update = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE order_id = :order_id");
            $stmt_update->execute(['order_id' => $order_id]);
            $orderDetails .= "<p><strong>Payment Status:</strong> Failed</p>";
            $orderDetails .= "<p>Your payment attempt failed. Please try again or contact support for assistance.</p>";
            sendOrderStatusEmail($order['email'], 'Payment Failed - Glamour Salon', $orderDetails);
            error_log("Payment failed for order ID: {$order_id}. Email sent.");
            break;

        case -3: // Chargeback
            $stmt_update = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE order_id = :order_id");
            $stmt_update->execute(['order_id' => $order_id]);
            $orderDetails .= "<p><strong>Payment Status:</strong> Chargeback</p>";
            $orderDetails .= "<p>A chargeback has been issued for your payment. Please contact support for further details.</p>";
            sendOrderStatusEmail($order['email'], 'Chargeback Received - Glamour Salon', $orderDetails);
            error_log("Chargeback received for order ID: {$order_id}. Email sent.");
            break;

        default:
            error_log("Unhandled payment status code: {$status_code} for order ID: {$order_id}.");
    }
} else {
    error_log("Invalid payment notification for order ID: {$order_id}. Signature mismatch.");
}
?>