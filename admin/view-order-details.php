<?php
include 'header.php';
include '../dbconnect.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch the order details including address and user details
    $stmt_order = $pdo->prepare("
        SELECT o.*, u.first_name AS user_first_name, u.last_name AS user_last_name, u.email AS user_email, u.telephone AS user_telephone
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        WHERE o.order_id = :order_id
    ");
    $stmt_order->execute(['order_id' => $order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

    // Fetch the order items
    $stmt_items = $pdo->prepare("
        SELECT * 
        FROM order_items 
        WHERE order_id = :order_id
    ");
    $stmt_items->execute(['order_id' => $order_id]);
    $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container ptb-100">
    <h3>Order Details</h3>
    <div id="order-details">
        <table class="table table-bordered">
            <tr>
                <th>Order ID</th>
                <td><?= $order['order_id'] ?></td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td><?= $order['first_name'] . ' ' . $order['last_name'] ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $order['email'] ?></td>
            </tr>
            <tr>
                <th>Telephone</th>
                <td><?= $order['telephone'] ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= $order['address'] ?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?= $order['city'] ?></td>
            </tr>
            <tr>
                <th>Postal Code</th>
                <td><?= $order['postal_code'] ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?= $order['country'] ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <td>LKR <?= number_format($order['total'], 2) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= ucfirst($order['status']) ?></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td><?= ucfirst(str_replace('_', ' ', $order['payment_method'])) ?></td>
            </tr>
        </table>

        <h3>Order Items</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>LKR <?= number_format($item['price'], 2) ?></td>
                        <td>LKR <?= number_format($item['total'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button onclick="printOrder()" class="btn btn-primary ce5">Print</button>
    <a href="download-order-pdf.php?order_id=<?= $order_id ?>" class="btn btn-primary ce5">Download PDF</a>
</div>

<script>
function printOrder() {
    var printContents = document.getElementById('order-details').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<?php include 'footer.php'; ?>