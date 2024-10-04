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
        $mail->Subject = 'Order Confirmation';
        $mail->Body = $orderDetails;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed with the checkout.'); window.location.href = 'login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user_id from session
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the database
    $stmt_user = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt_user->execute(['user_id' => $user_id]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    // Redirect to my-account.php if user details are missing
    if (!$user || empty($user['address']) || empty($user['city']) || empty($user['postal_code']) || empty($user['country'])) {
        echo "<script>alert('Please fill in your address details in your account.'); window.location.href = 'my-account.php';</script>";
        exit;
    }

    // Calculate the cart total dynamically
    $cart_total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $cart_total += $product['price'] * $product['qty'];
        }
    }

    if ($cart_total <= 0) {
        echo "<script>alert('Your cart is empty or there was an issue with the total calculation. Please try again.'); window.location.href = 'cart.php';</script>";
        exit;
    }

    $payment_method = $_POST['payment_method'];

    $stmt_order = $pdo->prepare("
        INSERT INTO orders (user_id, first_name, last_name, email, telephone, address, city, postal_code, country, total, payment_method)
        VALUES (:user_id, :first_name, :last_name, :email, :telephone, :address, :city, :postal_code, :country, :total, :payment_method)
    ");
    $stmt_order->execute([
        'user_id' => $user_id,
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'email' => $user['email'],
        'telephone' => $user['telephone'],
        'address' => $user['address'],
        'city' => $user['city'],
        'postal_code' => $user['postal_code'],
        'country' => $user['country'],
        'total' => $cart_total,
        'payment_method' => $payment_method
    ]);
    $order_id = $pdo->lastInsertId();

    // Insert order items into order_items table
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $stmt_item = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
            VALUES (:order_id, :product_id, :product_name, :quantity, :price)
        ");
        $stmt_item->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'product_name' => $product['product_name'],
            'quantity' => $product['qty'],
            'price' => $product['price']
        ]);
    }

    // Prepare email order details
    $orderDetails = "<h2>Order Confirmation</h2>";
    $orderDetails .= "<p>Order ID: {$order_id}</p>";
    $orderDetails .= "<p>Name: {$user['first_name']} {$user['last_name']}</p>";
    $orderDetails .= "<p>Address: {$user['address']}, {$user['city']}, {$user['country']}, {$user['postal_code']}</p>";
    $orderDetails .= "<p>Total: LKR " . number_format($cart_total, 2) . "</p>";

    foreach ($_SESSION['cart'] as $product) {
        $orderDetails .= "<p>{$product['product_name']} - Qty: {$product['qty']} - Total: LKR " . number_format($product['qty'] * $product['price'], 2) . "</p>";
    }

    if ($payment_method == 'bank_transfer') {
        $orderDetails .= "<p><strong>Bank Transfer Details:</strong></p>";
        $orderDetails .= "<p>Bank: Sampath Bank<br>Account Name: Glamour Salon<br>Account Number: 437566485674<br>Branch: Colombo</p>";
    } else {
        $orderDetails .= "<p><strong>Payment Method: Cash on Delivery</strong></p>";
    }

    sendOrderConfirmationEmail($user['email'], $orderDetails);

    // Clear cart and redirect to Home (index.php)
    unset($_SESSION['cart']);
    echo "<script>alert('Order placed successfully! Redirecting to home...'); window.location.href = 'index.php';</script>";
}
?>

<section class="checkout-area ptb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="checkout-section">
                    <h4>Placing your order...</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>