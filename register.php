<?php
include 'header.php';
include 'dbconnect.php';

// Handle registration submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    
    // Check if the email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        $message = "An account with this email already exists.";
        $message_type = 'danger';
    } else {
        // Insert new user
        $stmt = $pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password, telephone) 
            VALUES (:first_name, :last_name, :email, :password, :telephone)
        ");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'telephone' => $telephone
        ]);

        $message = "Account created successfully! Please log in.";
        $message_type = 'success';
    }
}
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Register</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Register</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="register-area ptb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-content">
                    <h2 class="text-center">Create your account</h2>

                    <?php if (isset($message)): ?>
                        <div class="mt-20 alert alert-<?= $message_type ?>"><?= $message ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" required placeholder="Enter your first name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" required placeholder="Enter your last name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input type="tel" class="form-control" name="telephone" required placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block mb-10">Register</button>
                        </div>
                        <div class="text-center">
                            <p>Already have an account? <a href="login.php">Login here</a></p>
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