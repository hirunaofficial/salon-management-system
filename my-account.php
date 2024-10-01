<?php 
include 'header.php';
include 'dbconnect.php';

// Start session and check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch the logged-in user's data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Update personal information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update personal information
    if (isset($_POST['update_info'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $fax = $_POST['fax'];

        $stmt = $pdo->prepare("
            UPDATE users SET 
            first_name = :first_name, 
            last_name = :last_name, 
            email = :email, 
            telephone = :telephone, 
            fax = :fax 
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'telephone' => $telephone,
            'fax' => $fax,
            'user_id' => $user_id
        ]);
        $message = 'Account information updated successfully.';
    }

    // Update password
    if (isset($_POST['change_password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
        $stmt->execute(['password' => $password, 'user_id' => $user_id]);
        $message = 'Password updated successfully.';
    }

    // Update address
    if (isset($_POST['update_address'])) {
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $postal_code = $_POST['postal_code'];

        $stmt = $pdo->prepare("
            UPDATE users SET 
            address = :address, 
            city = :city, 
            country = :country, 
            postal_code = :postal_code 
            WHERE user_id = :user_id
        ");
        $stmt->execute([
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'postal_code' => $postal_code,
            'user_id' => $user_id
        ]);
        $message = 'Address updated successfully.';
    }
}
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">My Account</h2>
                    <ul>
                        <li><a class="active" href="#">Home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="collapse_area coll2 ptb-90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (isset($message)): ?>
                    <div class="alert alert-success"><?= $message ?></div>
                <?php endif; ?>
                <div class="faq-accordion">
                    <div class="panel-group pas7" id="accordion" role="tablist" aria-multiselectable="true">
                        
                        <!-- Account Information -->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a class="collapsed method" role="button" data-bs-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Edit your account information <i class="zmdi zmdi-caret-down"></i></a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                <div class="row align-items-center">
                                    <div class="col-12 easy2">
                                        <h1>My Account Information</h1>
                                        <form class="form-horizontal" action="" method="POST">
                                            <fieldset>
                                                <legend>Your Personal Details</legend>
                                                <div class="form-group row align-items-center required pt-5 mt-0">
                                                    <label class="col-md-2 control-label">First Name </label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="text" name="first_name" value="<?= $user['first_name'] ?>" placeholder="First Name" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center required">
                                                    <label class="col-md-2 control-label">Last Name</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="text" name="last_name" value="<?= $user['last_name'] ?>" placeholder="Last Name" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center required">
                                                    <label class="col-md-2 control-label">E-Mail</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="email" name="email" value="<?= $user['email'] ?>" placeholder="E-Mail" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center required">
                                                    <label class="col-md-2 control-label">Telephone</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="tel" name="telephone" value="<?= $user['telephone'] ?>" placeholder="Telephone" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center">
                                                    <label class="col-md-2 control-label">Fax</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="text" name="fax" value="<?= $user['fax'] ?>" placeholder="Fax">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                                <div class="pull-left">
                                                    <a class="btn btn-default ce5" href="#">Back</a>
                                                </div>
                                                <div class="pull-right">
                                                    <button class="btn btn-primary ce5" type="submit" name="update_info">Continue</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Change your password <i class="zmdi zmdi-caret-down"></i></a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                <div class="row align-items-center">
                                    <div class="col-12 easy2">
                                        <h1>Change Password</h1>
                                        <form class="form-horizontal" action="" method="POST">
                                            <fieldset>
                                                <legend>Your Password</legend>
                                                <div class="form-group row align-items-center required pt-5 mt-0">
                                                    <label class="col-md-2 control-label">Password</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="password" name="password" placeholder="New Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center required">
                                                    <label class="col-md-2 control-label">Confirm Password</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control" type="password" placeholder="Confirm Password" required>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                                <div class="pull-left">
                                                    <a class="btn btn-default ce5" href="#">Back</a>
                                                </div>
                                                <div class="pull-right">
                                                    <button class="btn btn-primary ce5" type="submit" name="change_password">Continue</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Book Entries -->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Modify your address book entries <i class="zmdi zmdi-caret-down"></i></a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                <div class="easy2">
                                    <h1 class="mb-20">Address Book Entries</h1>

                                    <!-- Edit Address Form -->
                                    <form action="" method="POST">
                                        <div class="form-group row align-items-center required">
                                            <label class="col-md-2 control-label">Address</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="address" value="<?= $user['address'] ?>" placeholder="Address" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center required">
                                            <label class="col-md-2 control-label">City</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="city" value="<?= $user['city'] ?>" placeholder="City" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center required">
                                            <label class="col-md-2 control-label">Country</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="country" value="<?= $user['country'] ?>" placeholder="Country" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center required">
                                            <label class="col-md-2 control-label">Postal Code</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="text" name="postal_code" value="<?= $user['postal_code'] ?>" placeholder="Postal Code" required>
                                            </div>
                                        </div>
                                        <div class="buttons d-flex justify-content-between flex-wrap mt-5">
                                            <div class="pull-left">
                                                <a class="btn btn-default ce5" href="#">Back</a>
                                            </div>
                                            <div class="pull-right">
                                                <button class="btn btn-primary ce5" type="submit" name="update_address">Update Address</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <a class="collap mt-2" href="wishlist.php">Modify your wish list <i class="zmdi zmdi-caret-down"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>