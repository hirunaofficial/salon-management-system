<?php
include 'header.php';
include 'dbconnect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script type='text/javascript'>
            window.location.href = 'login.php';
          </script>";
    exit;
}

// Handle adding product to wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wishlist'])) {
    $product_id = $_POST['product_id'];
    $qty = isset($_POST['qty']) ? $_POST['qty'] : 1;
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the wishlist
    $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $wishlist_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($wishlist_item) {
        // Update the quantity if the product is already in the wishlist
        $stmt = $pdo->prepare("UPDATE wishlist SET qty = qty + :qty WHERE wishlist_id = :wishlist_id");
        $stmt->execute(['qty' => $qty, 'wishlist_id' => $wishlist_item['wishlist_id']]);
        $message = "Product quantity updated in the wishlist!";
    } else {
        // Insert new product into the wishlist
        $stmt = $pdo->prepare("
            INSERT INTO wishlist (user_id, product_id, qty)
            VALUES (:user_id, :product_id, :qty)
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'qty' => $qty
        ]);
        $message = "Product added to the wishlist!";
    }
}

// Fetch wishlist items for the logged-in user
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT w.wishlist_id, p.product_id, p.product_name, p.price, w.qty
    FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle wishlist item removal
if (isset($_GET['remove'])) {
    $wishlist_id = $_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE wishlist_id = :wishlist_id AND user_id = :user_id");
    $stmt->execute([
        'wishlist_id' => $wishlist_id,
        'user_id' => $user_id
    ]);
    echo "<script type='text/javascript'>
            window.location.href = 'wishlist.php';
          </script>";
    exit;
}
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Wishlist</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="shopping-cart-area pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="s-cart-all">
                    <div class="page-title">
                        <h1>Wishlist :</h1>
                    </div>

                    <?php if (isset($message)): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>

                    <div class="cart-form table-responsive ma">
                        <table id="shopping-cart-table" class="data-table cart-table">
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Remove</th>
                            </tr>
                            <?php if (!empty($wishlist_items)): ?>
                                <?php foreach ($wishlist_items as $item): ?>
                                    <tr>
                                        <td class="sop-cart">
                                            <a href="products.php">
                                                <?= $item['product_name'] ?>
                                            </a>
                                        </td>
                                        <td class="sop-cart">LKR <?= number_format($item['price'], 2) ?></td>
                                        <td class="sop-icon">
                                            <a href="wishlist.php?remove=<?= $item['wishlist_id'] ?>" class="remove">
                                                <i class="zmdi zmdi-close-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Your wishlist is empty.</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>