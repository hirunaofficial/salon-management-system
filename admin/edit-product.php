<?php
include '../dbconnect.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendStockNotificationEmail($product_name, $product_description, $product_price, $product_link, $subscribers) {
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

        // Add all subscriber emails
        foreach ($subscribers as $subscriber) {
            $mail->addAddress($subscriber['email']);
        }

        $mail->isHTML(true);
        $mail->Subject = 'Product Back in Stock: ' . $product_name;
        $mail->Body = "<h2>Good News!</h2>
                       <p>The product <strong>$product_name</strong> is now back in stock!</p>
                       <p>$product_description</p>
                       <p>Price: LKR " . number_format($product_price, 2) . "</p>
                       <p><a href='$product_link'>Click here to view the product page</a></p>
                       <p>Visit our website to purchase it now!</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock_status = $_POST['stock_status'];
    $image_url = $_POST['current_image_url'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/shop/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        if ($_FILES['image']['size'] > 5000000) {
            echo "<script>alert('Sorry, your file is too large.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = "images/shop/" . basename($_FILES['image']['name']);
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }
    }

    try {
        // Fetch the current stock status before update
        $stmt_current_status = $pdo->prepare("SELECT stock_status, description, price FROM products WHERE product_id = :product_id");
        $stmt_current_status->execute([':product_id' => $product_id]);
        $current_product = $stmt_current_status->fetch(PDO::FETCH_ASSOC);
        $current_stock_status = $current_product['stock_status'];
        $product_description = $current_product['description'];
        $product_price = $current_product['price'];

        // Update the product
        $stmt = $pdo->prepare("
            UPDATE products 
            SET product_name = :product_name, description = :description, category = :category, price = :price, stock_status = :stock_status, image_url = :image_url
            WHERE product_id = :product_id
        ");
        $stmt->execute([
            ':product_name' => $product_name,
            ':description' => $description,
            ':category' => $category,
            ':price' => $price,
            ':stock_status' => $stock_status,
            ':image_url' => $image_url,
            ':product_id' => $product_id
        ]);

        // Check if stock status has changed from out_of_stock to in_stock
        if ($current_stock_status === 'out_of_stock' && $stock_status === 'in_stock') {
            // Fetch all wishlist users for this product
            $stmt_wishlist_users = $pdo->prepare("SELECT u.email FROM wishlist w JOIN users u ON w.user_id = u.user_id WHERE w.product_id = :product_id");
            $stmt_wishlist_users->execute([':product_id' => $product_id]);
            $subscribers = $stmt_wishlist_users->fetchAll(PDO::FETCH_ASSOC);

            $product_link = "http://" . $_SERVER['HTTP_HOST'] . "/products.php";

            if (!empty($subscribers)) {
                sendStockNotificationEmail($product_name, $product_description, $product_price, $product_link, $subscribers);
            }
        }

        echo "<script>alert('Product updated successfully!'); window.location.href = 'manage-products.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to update product: " . $e->getMessage() . "'); window.location.href = 'manage-products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-products.php';</script>";
}
?>