<?php 
session_start(); 

if (isset($_SESSION['user_id'])) {
    require_once 'dbconnect.php';
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Glamour Salon</title>
    <meta name="description" content="Luxury hair and beauty services at Glamour Salon. Discover the best haircuts, beauty treatments, and pampering experiences.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
</head>

<body>

    <div class="wrapper">
        <div id="header" class="hs-header bg-dark">
            <div id="sticky-header-with-topbar" class="header-wrap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-lg-2 d-none d-md-block">
                            <div class="hs-logo">
                                <a href="index.php"><img src="images/logo/hair-salon.png" alt="hair salon logo"></a>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <div class="hs-header-top">
                                <div class="header-top-left"></div>
                                <ul class="hs-social-icon">
                                    <li><a href="cart.php"><i class="zmdi zmdi-shopping-cart"></i> <span class="hide-text">Cart</span></a></li>
                                    
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <li><a href="manage_orders.php"><i class="zmdi zmdi-receipt"></i> <span class="hide-text">Manage Orders</span></a></li>
                                        <li><a href="manage_appointments.php"><i class="zmdi zmdi-calendar"></i> <span class="hide-text">Manage Appointments</span></a></li>

                                        <?php if ($user['role'] === 'admin'): ?>
                                            <li><a href="my-account.php"><i class="zmdi zmdi-account"></i> <span class="hide-text">My Account</span></a></li>
                                            <li><a href="admin"><i class="zmdi zmdi-settings"></i> <span class="hide-text">Admin</span></a></li>

                                        <?php elseif ($user['role'] === 'staff'): ?>
                                            <li><a href="my-account.php"><i class="zmdi zmdi-account"></i> <span class="hide-text">My Account</span></a></li>
                                            <li><a href="admin"><i class="zmdi zmdi-settings"></i> <span class="hide-text">Staff</span></a></li>

                                        <?php else: ?>
                                            <li><a href="my-account.php"><i class="zmdi zmdi-account"></i> <span class="hide-text">My Account</span></a></li>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="hs-mainmenu-wrap d-none d-md-block">
                                <nav class="mainmenu-nav">
                                    <ul class="main-menu">
                                        <li class="active"><a href="index.php">Home</a></li>
                                        <li><a href="about.php">About Us</a></li>
                                        <li><a href="services.php">Services</a></li>
                                        <li><a href="products.php">Products</a></li>
                                        <li><a href="appointment.php">Appointment</a></li>
                                        <li><a href="gallery.php">Gallery</a></li>
                                        <li><a href="blog.php">Blog</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>

                                        <?php if (isset($_SESSION['user_id'])): ?>
                                            <li><a href="logout.php">Logout</a></li>
                                        <?php else: ?>
                                            <li><a href="login.php">Login</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-area d-block d-md-none">
                <div class="fluid-container mobile-menu-container">
                    <div class="mobile-logo"><a href="index.php"><img src="images/logo/hair-salon.png" alt="Mobile logo"></a></div>
                    <div class="mobile-menu clearfix">
                        <nav id="mobile_dropdown">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About</a></li>
                                <li><a href="services.php">Services</a></li>
                                <li><a href="products.php">Products</a></li>
                                <li><a href="appointment.php">Appointment Booking</a></li>
                                <li><a href="gallery.php">Gallery</a></li>
                                <li><a href="blog.php">Blog</a></li>
                                <li><a href="contact.php">Contact</a></li>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li><a href="my_account.php">My Account</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                <?php else: ?>
                                    <li><a href="login.php">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>  
                </div>
            </div>
        </div>
    </div>