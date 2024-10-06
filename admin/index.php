<?php 
include 'header.php'; 
include '../dbconnect.php';

// Fetch daily appointments count
$stmt_appointments = $pdo->prepare("SELECT COUNT(*) AS daily_appointments FROM appointments WHERE DATE(appointment_date) = CURDATE()");
$stmt_appointments->execute();
$daily_appointments = $stmt_appointments->fetch(PDO::FETCH_ASSOC)['daily_appointments'];

// Fetch total users count
$stmt_users = $pdo->prepare("SELECT COUNT(*) AS total_users FROM users");
$stmt_users->execute();
$total_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['total_users'];

// Fetch total orders count
$stmt_orders = $pdo->prepare("SELECT COUNT(*) AS total_orders FROM orders");
$stmt_orders->execute();
$total_orders = $stmt_orders->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Fetch the logged-in user's role
$user_id = $_SESSION['user_id'];
$stmt_role = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt_role->execute(['user_id' => $user_id]);
$user_role = $stmt_role->fetch(PDO::FETCH_ASSOC)['role'];
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <?php if ($user_role === 'admin'): ?>
                        <h2 class="page-title">Admin Dashboard</h2>
                    <?php elseif ($user_role === 'staff'): ?>
                        <h2 class="page-title">Staff Dashboard</h2>
                    <?php endif; ?>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <?php if ($user_role === 'admin'): ?>
                            <li>Admin Dashboard</li>
                        <?php elseif ($user_role === 'staff'): ?>
                            <li>Staff Dashboard</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hs-membership-packages" class="hs-membership-packages ptb-30">
    <div class="container text-center">
        <div class="row justify-content-center mt-40 mb-n6">
            <div class="col-md-6 col-lg-4 mb-6">
                <div class="hs-priceing-box">
                    <div class="hs-price-head">
                        <h4>Daily Appointments</h4>
                        <div class="hs-price-box">
                            <p><?= $daily_appointments ?>+</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if ($user_role === 'admin'): ?>
            <div class="col-md-6 col-lg-4 mb-6">
                <div class="hs-priceing-box">
                    <div class="hs-price-head">
                        <h4>Total Users</h4>
                        <div class="hs-price-box">
                            <p><?= $total_users ?>+</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-6">
                <div class="hs-priceing-box">
                    <div class="hs-price-head">
                        <h4>Total Orders</h4>
                        <div class="hs-price-box">
                            <p><?= $total_orders ?>+</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="hs-service-area" class="hs-service-area ptb-50 bg-gray">
    <div class="container">
        <div class="row mb-n6">

            <?php if ($user_role === 'admin'): ?>
                <div class="col-lg-4 col-md-6 mb-6">
                    <a href="manage-users.php">
                        <div class="single-service-area">
                            <div class="service-icon">
                                <img src="../images/icons/manage_users.png" alt="Manage Users">
                            </div>
                            <h4 class="ser-vice-tit">Manage Users</h4>
                            <p class="ser-pra">View, edit, and manage registered users.</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-6">
                    <a href="manage-services.php">
                        <div class="single-service-area">
                            <div class="service-icon">
                                <img src="../images/icons/edit_services.png" alt="Manage Services">
                            </div>
                            <h4 class="ser-vice-tit">Manage Services</h4>
                            <p class="ser-pra">Add, edit, or remove salon services.</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-6">
                    <a href="manage-products.php">
                        <div class="single-service-area">
                            <div class="service-icon">
                                <img src="../images/icons/manage_products.png" alt="Manage Products">
                            </div>
                            <h4 class="ser-vice-tit">Manage Products</h4>
                            <p class="ser-pra">Manage salon products and inventory.</p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>

            <div class="col-lg-4 col-md-6 mb-6">
                <a href="manage-appointments.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/manage_appointments.png" alt="Manage Appointments">
                        </div>
                        <h4 class="ser-vice-tit">Manage Appointments</h4>
                        <p class="ser-pra">Manage client bookings and schedules.</p>
                    </div>
                </a>
            </div>

            <?php if ($user_role === 'admin'): ?>
            <div class="col-lg-4 col-md-6 mb-6">
                <a href="manage-orders.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/manage_orders.png" alt="Manage Orders">
                        </div>
                        <h4 class="ser-vice-tit">Manage Orders</h4>
                        <p class="ser-pra">Track and manage customer orders.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 mb-6">
                <a href="manage-blog.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/manage_blog.png" alt="Manage Blog">
                        </div>
                        <h4 class="ser-vice-tit">Manage Blog</h4>
                        <p class="ser-pra">Publish and manage blog articles.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 mb-6">
                <a href="manage-comments.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/manage_comments.png" alt="Manage Comments">
                        </div>
                        <h4 class="ser-vice-tit">Manage Comments</h4>
                        <p class="ser-pra">Manage comments related to blog articles.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 mb-6">
                <a href="edit-gallery.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/edit_gallery.png" alt="Edit Gallery Images">
                        </div>
                        <h4 class="ser-vice-tit">Edit Gallery Images</h4>
                        <p class="ser-pra">Update salon gallery images.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 mb-6">
                <a href="contact-messages.php">
                    <div class="single-service-area">
                        <div class="service-icon">
                            <img src="../images/icons/contact_responses.png" alt="Contact Message Responses">
                        </div>
                        <h4 class="ser-vice-tit">Contact Message Responses</h4>
                        <p class="ser-pra">Manage and respond to customer inquiries.</p>
                    </div>
                </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>