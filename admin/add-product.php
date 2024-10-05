<?php
include '../dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock_status = $_POST['stock_status'];

    // Handle image upload
    $target_dir = "../images/shop/";
    $image_url = "";

    if (!empty($_FILES['image']['name'])) {
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        // Check file size (limit to 5MB)
        if ($_FILES['image']['size'] > 5000000) {
            echo "<script>alert('Sorry, your file is too large.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        // Allow certain file formats (jpg, png, jpeg, gif)
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }

        // Save the file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_url = "images/shop/" . basename($_FILES['image']['name']);
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'manage-products.php';</script>";
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO products (product_name, description, category, price, stock_status, image_url) 
            VALUES (:product_name, :description, :category, :price, :stock_status, :image_url)
        ");
        $stmt->execute([
            ':product_name' => $product_name,
            ':description' => $description,
            ':category' => $category,
            ':price' => $price,
            ':stock_status' => $stock_status,
            ':image_url' => $image_url
        ]);
        echo "<script>alert('Product added successfully!'); window.location.href = 'manage-products.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to add product: " . $e->getMessage() . "'); window.location.href = 'manage-products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'manage-products.php';</script>";
}
?>