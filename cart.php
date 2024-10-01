<?php 
include 'header.php';

// Handle adding or updating items in the cart
if (isset($_POST['add_to_cart']) || isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = (float) $_POST['price']; // Cast price to float
    $qty = (int) $_POST['qty']; // Cast quantity to integer

    // Check if the cart session exists, if not, create one
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already exists in the cart, update the quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['qty'] = $qty; // Update quantity
    } else {
        // Add the new product to the cart
        $_SESSION['cart'][$product_id] = [
            'product_name' => $product_name,
            'price' => $price,
            'qty' => $qty
        ];
    }
}

// Handle removal of items from the cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
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
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
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
                                        <td class="sop-cart">$<?php echo number_format((float)$product['price'], 2); ?></td>
                                        <td class="sop-cart">$<?php echo number_format((float)$product['price'] * (int)$product['qty'], 2); ?></td>
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
                        <td class="text-center">$<?php echo number_format($cart_total, 2); ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Total:</strong></td>
                        <td class="text-center">$<?php echo number_format($cart_total, 2); ?></td>
                    </tr>
                </table>
                <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                    <div class="pull-left mb-1">
                        <a href="products.php"><button class="button bn7"><span>Continue Shopping</span></button></a>
                    </div>
                    <div class="pull-right no9">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="checkout.php"><button class="button bn7"><span>Checkout</span></button></a>
                        <?php else: ?>
                            <a href="login.php"><button class="button bn7"><span>Login to Checkout</span></button></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php' ?>