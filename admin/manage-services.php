<?php 
include 'header.php'; 
include '../dbconnect.php';

// Fetch current logged-in user's role to restrict access
$user_id = $_SESSION['user_id'];
$stmt_role = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt_role->execute(['user_id' => $user_id]);
$user = $stmt_role->fetch(PDO::FETCH_ASSOC);

// Restrict access for non-admin users
if ($user['role'] !== 'admin') {
    echo "<script>alert('Access denied.'); window.location.href = 'index.php';</script>";
    exit;
}

$message = "";

// Fetch all services
$stmt = $pdo->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Services</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">

    <!-- Display Success or Error Messages -->
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <!-- Button to trigger Add Service Modal -->
    <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</button>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Member Price</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= $service['name'] ?></td>
                    <td><?= $service['category'] ?></td>
                    <td><?= $service['description'] ?></td>
                    <td><?= $service['price'] ?></td>
                    <td><?= $service['member_price'] ?></td>
                    <td><?= $service['duration'] ?> mins</td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editServiceModal<?= $service['service_id'] ?>">Edit</button>
                        <a href="delete-service.php?service_id=<?= $service['service_id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                    </td>
                </tr>

                <!-- Edit Service Modal -->
                <div class="modal fade" id="editServiceModal<?= $service['service_id'] ?>" tabindex="-1" aria-labelledby="editServiceModalLabel<?= $service['service_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="edit-service.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalLabel<?= $service['service_id'] ?>">Edit Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
                                    <div class="form-group">
                                        <label for="name">Service Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= $service['name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $service['category'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" required><?= $service['description'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" value="<?= $service['price'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="member_price">Member Price</label>
                                        <input type="number" class="form-control" name="member_price" value="<?= $service['member_price'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration">Duration (mins)</label>
                                        <input type="number" class="form-control" name="duration" value="<?= $service['duration'] ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary ce5" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ce5">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="add-service.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Service Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="member_price">Member Price</label>
                            <input type="number" class="form-control" name="member_price" required>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration (mins)</label>
                            <input type="number" class="form-control" name="duration" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary ce5" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_service" class="btn btn-primary ce5">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>