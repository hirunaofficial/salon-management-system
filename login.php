<?php
include 'header.php';
include 'dbconnect.php';

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Fetch user data based on email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        echo "<script type='text/javascript'>
                window.location.href = 'my-account.php';
              </script>";;
        exit;
    } else {
        $message = "Invalid login credentials.";
        $message_type = 'danger';
    }
}
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Login</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Login</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="login-area ptb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-content">
                    <h2 class="text-center">Login to your account</h2>

                    <?php if (isset($message)): ?>
                        <div class="mt-20 alert alert-<?= $message_type ?>"><?= $message ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block mb-10">Login</button>
                        </div>
                        <div class="text-center">
                            <p>Don't have an account? <a href="register.php">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #000000;
    border-radius: 4px;
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #000000;
    border: none;
    padding: 12px;
    font-size: 16px;
    width: 100%;
}

.btn-primary:hover {
    background-color: #000000;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}
</style>

<?php include 'footer.php'; ?>