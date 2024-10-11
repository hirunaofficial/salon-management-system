<?php
include 'header.php';

// Initialize message variables
$message = '';
$message_type = '';

// Handle adding or updating items in the cart
if (isset($_POST['add_to_cart']) || isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price']; // Cast price to float
    $qty = (int) $_POST['qty']; // Cast quantity to integer

    // Check if the cart session exists, if not, create one
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already exists in the cart, update the quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['qty'] = $qty; // Update quantity
        $message = "Product quantity updated in the cart.";
        $message_type = 'success';
    } else {
        // Add the new product to the cart
        $_SESSION['cart'][$product_id] = [
            'product_name' => $product_name,
            'price' => $price,
            'qty' => $qty
        ];
        $message = "Product added to the cart.";
        $message_type = 'success';
    }
}

// Handle removal of items from the cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    $message = "Product removed from the cart.";
    $message_type = 'danger';
}

// Calculate total
$cart_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $cart_total += (float) $product['price'] * (int) $product['qty']; // Ensure both are numeric
    }
}
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Shopping Cart</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Shopping Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="shopping-cart-area pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <?php if ($message): ?>
                    <div class="alert alert-<?= $message_type ?> alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="s-cart-all">
                    <div class="page-title">
                        <h1>Shopping Cart :</h1>
                    </div>
                    <div class="cart-form table-responsive ma">
                        <table id="shopping-cart-table" class="data-table cart-table">
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                                <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                                    <tr>
                                        <td class="sop-cart"><?php echo $product['product_name']; ?></td>
                                        <td class="cen">
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                                <input type="hidden" name="price" value="<?php echo number_format((float)$product['price'], 2); ?>">
                                                <input type="number" name="qty" value="<?php echo $product['qty']; ?>" min="1" style="width: 60px;">
                                                <button type="submit" name="update_cart" class="btn btn-primary" style="border: none; background-color: transparent;">
                                                    <i class="zmdi zmdi-refresh"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="sop-cart">LKR <?php echo number_format((float)$product['price'], 2); ?></td>
                                        <td class="sop-cart">LKR <?php echo number_format((float)$product['price'] * (int)$product['qty'], 2); ?></td>
                                        <td class="sop-icon">
                                            <a href="cart.php?remove=<?php echo $product_id; ?>" class="remove">
                                                <i class="zmdi zmdi-close-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Your cart is empty.</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="shop-collaps-area pb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered mt-5 mt-lg-0">
                    <tr>
                        <td class="text-center"><strong>Sub-Total:</strong></td>
                        <td class="text-center">LKR <?php echo number_format($cart_total, 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Shipping Charge:</strong></td>
                        <td class="text-center">Free Shipping</td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Total:</strong></td>
                        <td class="text-center">LKR <?php echo number_format($cart_total, 2); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="text-left mt-3">
                    <strong>Select Payment Method:</strong>
                </div>
                <form action="checkout.php" method="POST">
                        <div class="form-group">
                            <select name="payment_method" class="form-control" required>
                            <option value="online_payment">Online Transfer</option>
                            <option value="cod">Cash on Delivery</option>
                            </select>
                        </div>
                        <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                        <div class="pull-left mb-1">
                            <a href="products.php"><button class="button bn7"><span>Continue Shopping</span></button></a>
                        </div>
                        <div class="pull-right no9">
                            <button type="submit" class="button bn7"><span>Checkout</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>