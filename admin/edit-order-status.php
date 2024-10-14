<?php
include '../dbconnect.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendOrderUpdateEmail($email, $orderDetails) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($_ENV['SMTP_USER'], 'Glamour Store');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Order Update from Glamour Store';
        $mail->Body = $orderDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $payment_method = $_POST['payment_method'];

    $stmt = $pdo->prepare("UPDATE orders SET status = :status, payment_method = :payment_method WHERE order_id = :order_id");
    $stmt->execute(['status' => $status, 'payment_method' => $payment_method, 'order_id' => $order_id]);

    $stmt_order = $pdo->prepare("
        SELECT o.order_id, o.status, o.total, o.payment_method, o.created_at, u.first_name, u.last_name, u.email 
        FROM orders o 
        JOIN users u ON o.user_id = u.user_id 
        WHERE o.order_id = :order_id
    ");
    $stmt_order->execute(['order_id' => $order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    $orderDetails = "<h2>Order Update</h2>";
    $orderDetails .= "<p>Dear {$order['first_name']} {$order['last_name']},</p>";
    $orderDetails .= "<p>Your order (ID: {$order['order_id']}) has been updated with the following details:</p>";
    $orderDetails .= "<p><strong>Status:</strong> <span style='font-weight: bold; color: #5cb85c;'>" . ucfirst($order['status']) . "</span></p>";
    $orderDetails .= "<p><strong>Payment Method:</strong> " . ucfirst(str_replace('_', ' ', $order['payment_method'])) . "</p>";
    $orderDetails .= "<p><strong>Total Amount:</strong> LKR " . number_format($order['total'], 2) . "</p>";
    $orderDetails .= "<p><strong>Order Date:</strong> " . date('F d, Y', strtotime($order['created_at'])) . "</p>";
    $orderDetails .= "<p>If you have any questions, please feel free to contact us.</p>";
    $orderDetails .= "<p>Thank you for shopping with Glamour Store!</p>";

    sendOrderUpdateEmail($order['email'], $orderDetails);

    echo "<script>alert('Order status and payment method updated successfully, and the customer has been notified.'); window.location.href = 'manage-orders.php';</script>";
}
?>