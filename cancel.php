<?php
include 'dbconnect.php';
include 'header.php'; 

// Display cancellation message
echo "<div class='container mt-5'>";
echo "<div class='card border-light shadow-sm'>";
echo "<div class='card-header text-white'><h3 class='mb-0'>Order Cancelled</h3></div>";
echo "<div class='card-body'>";
echo "<p class='lead'>Your order has been cancelled.</p>";
echo "<p>If you encountered an issue during the payment process or changed your mind, please try again or contact our support team for assistance.</p>";
echo "<div class='d-flex justify-content-start mt-3'>";
echo "<a href='index.php' class='btn btn-primary ce5'>Go Back to Home</a>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

include 'footer.php';
?>
