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

// Fetch all staff members
$stmt = $pdo->prepare("SELECT * FROM staff");
$stmt->execute();
$staff_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Staff Members</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Staff Members</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addStaffMemberModal">Add Staff Member</button>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff_members as $staff): ?>
                <tr>
                    <td><?= $staff['first_name'] ?></td>
                    <td><?= $staff['last_name'] ?></td>
                    <td><?= $staff['email'] ?></td>
                    <td><?= $staff['phone'] ?></td>
                    <td><?= $staff['specialization'] ?></td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editStaffModal<?= $staff['staff_id'] ?>">Edit</button>
                        <a href="delete-staff-member.php?staff_id=<?= $staff['staff_id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
                    </td>
                </tr>

                <div class="modal fade" id="editStaffModal<?= $staff['staff_id'] ?>" tabindex="-1" aria-labelledby="editStaffModalLabel<?= $staff['staff_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="edit-staff-member.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStaffModalLabel<?= $staff['staff_id'] ?>">Edit Staff Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="staff_id" value="<?= $staff['staff_id'] ?>">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="<?= $staff['first_name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="<?= $staff['last_name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?= $staff['email'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="<?= $staff['phone'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="specialization">Specialization</label>
                                        <input type="text" class="form-control" name="specialization" value="<?= $staff['specialization'] ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary ce5">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="modal fade" id="addStaffMemberModal" tabindex="-1" aria-labelledby="addStaffMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="add-staff-member.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStaffMemberModalLabel">Add New Staff Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" name="specialization" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_staff" class="btn btn-primary ce5">Add Staff Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>