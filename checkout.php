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
        $mail->Subject = 'Order Details - Glamour Salon';
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
    echo "<script>alert('Please log in to proceed with the checkout.'); window.location.href = 'login.php';</script>";
    exit;
}

// Proceed with order creation after user confirms the order
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

    // Insert order into the database with 'unpaid' status
    $stmt_order = $pdo->prepare("
        INSERT INTO orders (user_id, first_name, last_name, email, telephone, address, city, postal_code, country, total, payment_method, status)
        VALUES (:user_id, :first_name, :last_name, :email, :telephone, :address, :city, :postal_code, :country, :total, :payment_method, 'unpaid')
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
        'payment_method' => $_POST['payment_method']
    ]);
    $order_id = $pdo->lastInsertId();

    // Insert order items into the order_items table
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

    // Prepare the email content with full order details
    $orderDetails = "<h2>Order Details</h2>";
    $orderDetails .= "<p><strong>Order ID:</strong> {$order_id}</p>";
    $orderDetails .= "<p><strong>Total Amount:</strong> LKR " . number_format($cart_total, 2) . "</p>";
    $orderDetails .= "<p><strong>Payment Method:</strong> " . $_POST['payment_method'] . "</p>";
    $orderDetails .= "<h3>Customer Information</h3>";
    $orderDetails .= "<p><strong>Name:</strong> {$user['first_name']} {$user['last_name']}</p>";
    $orderDetails .= "<p><strong>Email:</strong> {$user['email']}</p>";
    $orderDetails .= "<p><strong>Telephone:</strong> {$user['telephone']}</p>";
    $orderDetails .= "<p><strong>Address:</strong> {$user['address']}, {$user['city']}, {$user['postal_code']}, {$user['country']}</p>";
    $orderDetails .= "<h3>Order Items:</h3><ul>";

    foreach ($_SESSION['cart'] as $product) {
        $orderDetails .= "<li>{$product['product_name']} - Qty: {$product['qty']} - Price: LKR " . number_format($product['price'], 2) . "</li>";
    }

    $orderDetails .= "</ul>";
    $orderDetails .= "<p>Thank you for shopping with Glamour Salon!</p>";

    // Handle payment method logic
    if ($_POST['payment_method'] === 'online_payment') {
        // Send email for online payment
        if (!sendOrderConfirmationEmail($user['email'], $orderDetails)) {
            echo "<script>alert('There was an error sending the confirmation email. Please check your email details.');</script>";
        }

        // Prepare parameters for PayHere
        $merchant_id = $_ENV['PAYHERE_MERCHANT_ID'];
        $merchant_secret = $_ENV['PAYHERE_MERCHANT_SECRET'];
        $currency = 'LKR';
        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                number_format($cart_total, 2, '.', '') . 
                $currency .  
                strtoupper(md5($merchant_secret))
            )
        );

        // Prepare PayHere checkout form
        echo '<form method="post" action="https://sandbox.payhere.lk/pay/checkout" id="payhere_form">';
        echo '<input type="hidden" name="merchant_id" value="' . $merchant_id . '">';
        echo '<input type="hidden" name="return_url" value="' . $_ENV['PAYHERE_RETURN_URL'] . '">';
        echo '<input type="hidden" name="cancel_url" value="' . $_ENV['PAYHERE_CANCEL_URL'] . '">';
        echo '<input type="hidden" name="notify_url" value="' . $_ENV['PAYHERE_NOTIFY_URL'] . '">';
        echo '<input type="hidden" name="order_id" value="' . $order_id . '">';
        echo '<input type="hidden" name="items" value="Order No: ' . $order_id . '">';
        echo '<input type="hidden" name="currency" value="' . $currency . '">';
        echo '<input type="hidden" name="amount" value="' . number_format($cart_total, 2, '.', '') . '">';
        echo '<input type="hidden" name="first_name" value="' . $user['first_name'] . '">';
        echo '<input type="hidden" name="last_name" value="' . $user['last_name'] . '">';
        echo '<input type="hidden" name="email" value="' . $user['email'] . '">';
        echo '<input type="hidden" name="phone" value="' . $user['telephone'] . '">';
        echo '<input type="hidden" name="address" value="' . $user['address'] . '">';
        echo '<input type="hidden" name="city" value="' . $user['city'] . '">';
        echo '<input type="hidden" name="country" value="' . $user['country'] . '">';
        echo '<input type="hidden" name="hash" value="' . $hash . '">';
        echo '</form>';

        // Clear cart after successful order creation
        unset($_SESSION['cart']);

        // Redirect to PayHere
        echo '<script>document.getElementById("payhere_form").submit();</script>';
        exit;

    } elseif ($_POST['payment_method'] === 'cod') {
        // Prepare email content for Cash on Delivery
        $codOrderDetails = "<h2>Your order has been created</h2>";
        $codOrderDetails .= "<p>Order ID: {$order_id}</p>";
        $codOrderDetails .= "<p>Total Amount: LKR " . number_format($cart_total, 2) . "</p>";
        $codOrderDetails .= "<p>Status: <strong>Cash on Delivery</strong></p>";
        $codOrderDetails .= "<p>Your order will be delivered to the address provided.</p>";
        $codOrderDetails .= "<h3>Customer Information</h3>";
        $codOrderDetails .= "<p><strong>Name:</strong> {$user['first_name']} {$user['last_name']}</p>";
        $codOrderDetails .= "<p><strong>Email:</strong> {$user['email']}</p>";
        $codOrderDetails .= "<p><strong>Telephone:</strong> {$user['telephone']}</p>";
        $codOrderDetails .= "<p><strong>Address:</strong> {$user['address']}, {$user['city']}, {$user['postal_code']}, {$user['country']}</p>";
        $codOrderDetails .= "<h3>Order Items:</h3><ul>";

        foreach ($_SESSION['cart'] as $product) {
            $codOrderDetails .= "<li>{$product['product_name']} - Qty: {$product['qty']} - Price: LKR " . number_format($product['price'], 2) . "</li>";
        }

        $codOrderDetails .= "</ul>";
        $codOrderDetails .= "<p>Thank you for shopping with Glamour Salon!</p>";

        // Send email for Cash on Delivery
        if (!sendOrderConfirmationEmail($user['email'], $codOrderDetails)) {
            echo "<script>alert('There was an error sending the confirmation email. Please check your email details.');</script>";
        }

        // Clear cart after successful order creation
        unset($_SESSION['cart']);

        // Redirect to the return page with the order ID
        echo "<script>window.location.href = '" . $_ENV['PAYHERE_RETURN_URL'] . "?order_id={$order_id}';</script>";
        exit;
    }
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