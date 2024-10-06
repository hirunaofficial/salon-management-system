<?php
include 'header.php';
include '../dbconnect.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $stmt_order = $pdo->prepare("
        SELECT * 
        FROM orders 
        WHERE order_id = :order_id
    ");
    $stmt_order->execute(['order_id' => $order_id]);
    $order = $stmt_order->fetch(PDO::FETCH_ASSOC);

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
            <th>Total</th>
            <td>LKR <?= number_format($order['total'], 2) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= ucfirst($order['status']) ?></td>
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

<?php include 'footer.php'; ?>