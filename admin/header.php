<?php
session_start();
include '../dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to access this page.'); window.location.href = 'login.php';</script>";
    exit;
}

// Fetch the logged-in user's role from the database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Restrict access for non-admin or non-staff users
if ($user['role'] !== 'admin' && $user['role'] !== 'staff') {
    echo "<script>alert('Access denied.'); window.location.href = '../index.php';</script>";
    exit;
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Glamour Salon - Admin Dashboard</title>
    <meta name="description" content="Luxury hair and beauty services at Glamour Salon. Manage users, services, appointments, and more.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/core.css">
    <link rel="stylesheet" href="../css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../js/vendor/modernizr-3.11.2.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <div id="header" class="hs-header bg-dark">
            <div id="sticky-header-with-topbar" class="header-wrap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-lg-2 d-none d-md-block">
                            <div class="hs-logo">
                                <a href="index.php"><img src="../images/logo/hair-salon.png" alt="hair salon logo"></a>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <div class="hs-header-top">
                            <div class="header-top-left"></div>
                                <ul class="hs-social-icon">
                                <li><a href="../my-account.php"><i class="zmdi zmdi-home"></i> <span class="hide-text">Return to Home</span></a></li>
                                </ul>
                            </div>
                            <div class="hs-mainmenu-wrap d-none d-md-block">
                                <nav class="mainmenu-nav">
                                    <ul class="main-menu">
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <li><a href="manage-services.php">Manage Services</a></li>
                                            <li><a href="manage-products.php">Manage Products</a></li>
                                            <li><a href="manage-blog.php">Manage Blog</a></li>
                                        <?php elseif ($user['role'] === 'staff'): ?>
                                            <li><a href="manage-appointments.php">Manage Appointments</a></li>
                                            <li><a href="manage-orders.php">Manage Orders</a></li>
                                            <li><a href="manage-blog.php">Manage Blog</a></li>
                                        <?php endif; ?>
                                        <li><a href="../logout.php">Logout</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mobile-menu-area d-block d-md-none">
                <div class="fluid-container mobile-menu-container">
                    <div class="mobile-logo"><a href="index.php"><img src="../images/logo/hair-salon.png" alt="Mobile logo"></a></div>
                    <div class="mobile-menu clearfix">
                        <nav id="mobile_dropdown">
                            <ul>

                                <?php if ($user['role'] === 'admin'): ?>
                                    <li><a href="manage-users.php">Manage Users</a></li>
                                    <li><a href="manage-orders.php">Manage Orders</a></li>
                                    <li><a href="manage-appointments.php">Manage Appointments</a></li>
                                    <li><a href="manage-products.php">Manage Products</a></li>
                                    <li><a href="manage-services.php">Manage Services</a></li>
                                    <li><a href="manage-blog.php">Manage Blog</a></li>
                                    <li><a href="edit-gallery.php">Edit Gallery Images</a></li>
                                <?php elseif ($user['role'] === 'staff'): ?>
                                    <li><a href="manage-orders.php">Manage Orders</a></li>
                                    <li><a href="manage-appointments.php">Manage Appointments</a></li>
                                    <li><a href="manage-blog.php">Manage Blog</a></li>
                                    <li><a href="edit-gallery.php">Edit Gallery Images</a></li>
                                <?php endif; ?>

                                <li><a href="../logout.php">Logout</a></li>
                            </ul>
                        </nav>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</body>
</html>
