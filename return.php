<?php
include 'dbconnect.php';
include 'header.php';

// Check if an order ID is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch the order details
    $stmt_order = $pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $stmt_order->execute(['order_id' => $order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        // Fetch the order items
        $stmt_items = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt_items->execute(['order_id' => $order_id]);
        $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo '<div class="alert alert-danger" role="alert">Order not found. Please check the order ID and try again.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger" role="alert">No order ID provided. Please try again.</div>';
    exit;
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Thank you for your purchase!</h2>
            <p>Your order (ID: <?= htmlspecialchars($order_id) ?>) has been successfully placed and is now <?= htmlspecialchars(ucfirst($order['status'])) ?>.</p>
        </div>

        <div class="col-12 mt-20">
            <h3 class="mb-3">Order Details</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Order ID</th>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td><?= htmlspecialchars($order['telephone']) ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?= htmlspecialchars($order['address'] . ', ' . $order['city'] . ', ' . $order['postal_code'] . ', ' . $order['country']) ?></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>LKR <?= number_format($order['total'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td><?= htmlspecialchars($order['payment_method'] === 'cod' ? 'Cash on Delivery' : 'Online Payment') ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                                // Define status labels based on payment method and status
                                switch ($order['status']) {
                                    case 'paid':
                                        echo '<span class="badge bg-success">Paid</span>';
                                        break;
                                    case 'pending':
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                        break;
                                    case 'cancelled':
                                        echo '<span class="badge bg-danger">Cancelled</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">' . htmlspecialchars(ucfirst($order['status'])) . '</span>';
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-12">
            <h3 class="mb-3">Order Items</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price (LKR)</th>
                        <th>Total (LKR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>