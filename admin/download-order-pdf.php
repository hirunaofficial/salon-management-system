<?php
include '../dbconnect.php';
require '../vendor/autoload.php';

use Fpdf\Fpdf;

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    try {
        // Fetch the order details
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
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

// Extend FPDF class to create a custom PDF
class PDF extends FPDF {
    // Header
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(80);
        $this->Cell(30, 10, 'Glamour Salon - Order Invoice', 0, 1, 'C');
        $this->Ln(10);
    }

    // Footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instantiate PDF class and generate PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Order Details', 0, 1);
$pdf->Cell(40, 10, 'Order ID:', 0, 0);
$pdf->Cell(40, 10, $order['order_id'], 0, 1);
$pdf->Cell(40, 10, 'Customer Name:', 0, 0);
$pdf->Cell(40, 10, $order['first_name'] . ' ' . $order['last_name'], 0, 1);
$pdf->Cell(40, 10, 'Total:', 0, 0);
$pdf->Cell(40, 10, 'LKR ' . number_format($order['total'], 2), 0, 1);

$pdf->Ln(10);

$pdf->Cell(0, 10, 'Order Items', 0, 1);
$pdf->Cell(70, 10, 'Product Name', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->Ln();

foreach ($order_items as $item) {
    $pdf->Cell(70, 10, $item['product_name'], 1);
    $pdf->Cell(30, 10, $item['quantity'], 1);
    $pdf->Cell(40, 10, 'LKR ' . number_format($item['price'], 2), 1);
    $pdf->Cell(40, 10, 'LKR ' . number_format($item['total'], 2), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'order_' . $order['order_id'] . '.pdf');
?>