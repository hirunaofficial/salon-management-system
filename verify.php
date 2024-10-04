<?php
include 'header.php';
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
    $email = $_POST['email'];
    $otp_input = $_POST['otp'];

    // Retrieve user data from the user_otp table
    $stmt = $pdo->prepare("SELECT * FROM user_otp WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $temp_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($temp_user) {
        // Check if OTP is expired
        if (strtotime($temp_user['otp_expiry']) < time()) {
            // If the OTP is expired, redirect to the registration page
            echo "<script type='text/javascript'>
                    alert('Your OTP has expired. Please register again.');
                    window.location.href = 'register.php';
                  </script>";
            exit;
        }

        // If OTP is valid and not expired
        if ($temp_user['otp_code'] == $otp_input) {
            // Move the user data from user_otp to users table
            $stmt_insert_user = $pdo->prepare("
                INSERT INTO users (first_name, last_name, email, password, telephone)
                VALUES (:first_name, :last_name, :email, :password, :telephone)
            ");
            $stmt_insert_user->execute([
                'first_name' => $temp_user['first_name'],
                'last_name' => $temp_user['last_name'],
                'email' => $temp_user['email'],
                'password' => $temp_user['password'],
                'telephone' => $temp_user['telephone']
            ]);

            // Delete the temporary data from user_otp table
            $stmt_delete_otp = $pdo->prepare("DELETE FROM user_otp WHERE email = :email");
            $stmt_delete_otp->execute(['email' => $email]);

            // Redirect to login page after success
            echo "<script type='text/javascript'>
                    alert('Verification successful! Redirecting to login page...');
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 2000);
                  </script>";
            exit;
        } else {
            // If OTP is invalid, redirect back to verify page
            echo "<script type='text/javascript'>
                    alert('Invalid OTP. Please try again.');
                    window.location.href = 'verify.php?email=$email';
                  </script>";
            exit;
        }
    } else {
        // Redirect to verify page if no OTP request is found
        echo "<script type='text/javascript'>
                alert('No OTP request found for this email.');
                window.location.href = 'verify.php?email=$email';
              </script>";
        exit;
    }
}
?>

<section class="verify-area ptb-90">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="verify-content">
                    <h2 class="text-center">Verify your account</h2>

                    <form action="verify.php" method="POST">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email']); ?>">
                        <div class="form-group">
                            <label>Enter OTP</label>
                            <input type="text" class="form-control" name="otp" required placeholder="Enter the OTP sent to your email">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="verify" class="btn btn-primary btn-block mb-10">Verify</button>
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