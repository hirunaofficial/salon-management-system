<?php 
include 'header.php'; 
include '../dbconnect.php';

// Fetch current logged-in user's role to restrict access
$user_id = $_SESSION['user_id'];
$stmt_role = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt_role->execute(['user_id' => $user_id]);
$user = $stmt_role->fetch(PDO::FETCH_ASSOC);

// Restrict access for non-admin and non-staff users
if ($user['role'] !== 'admin' && $user['role'] !== 'staff') {
    echo "<script>alert('Access denied.'); window.location.href = 'index.php';</script>";
    exit;
}

$is_staff = ($user['role'] === 'staff');

$message = "";

// Fetch today's appointments for logged-in staff (for role 'staff' users)
if ($is_staff) {
    // Fetching today's appointments for the staff
    $stmt_today = $pdo->prepare("
        SELECT appointments.*, CONCAT(users.first_name, ' ', users.last_name) AS user_full_name,
               services.name AS service_name, CONCAT(staff.first_name, ' ', staff.last_name) AS staff_full_name
        FROM appointments 
        LEFT JOIN users ON appointments.user_id = users.user_id
        LEFT JOIN services ON appointments.service_id = services.service_id
        LEFT JOIN users AS staff ON appointments.staff_id = staff.user_id
        WHERE appointments.appointment_date = CURDATE() AND appointments.staff_id = :staff_id
        ORDER BY appointments.appointment_time
    ");
    $stmt_today->execute(['staff_id' => $user_id]);
    $todays_appointments = $stmt_today->fetchAll(PDO::FETCH_ASSOC);

    // Fetching all appointments for the staff
    $stmt_all = $pdo->prepare("
        SELECT appointments.*, CONCAT(users.first_name, ' ', users.last_name) AS user_full_name,
               services.name AS service_name, CONCAT(staff.first_name, ' ', staff.last_name) AS staff_full_name
        FROM appointments 
        LEFT JOIN users ON appointments.user_id = users.user_id
        LEFT JOIN services ON appointments.service_id = services.service_id
        LEFT JOIN users AS staff ON appointments.staff_id = staff.user_id
        WHERE appointments.staff_id = :staff_id
        ORDER BY appointments.appointment_date, appointments.appointment_time
    ");
    $stmt_all->execute(['staff_id' => $user_id]);
    $appointments = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

} else {
    // Fetch all today's appointments if logged in as admin
    $stmt_today = $pdo->prepare("
        SELECT appointments.*, CONCAT(users.first_name, ' ', users.last_name) AS user_full_name,
               services.name AS service_name, CONCAT(staff.first_name, ' ', staff.last_name) AS staff_full_name
        FROM appointments 
        LEFT JOIN users ON appointments.user_id = users.user_id
        LEFT JOIN services ON appointments.service_id = services.service_id
        LEFT JOIN users AS staff ON appointments.staff_id = staff.user_id
        WHERE appointments.appointment_date = CURDATE()
        ORDER BY appointments.appointment_time
    ");
    $stmt_today->execute();
    $todays_appointments = $stmt_today->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all appointments for admin role
    $stmt_all = $pdo->prepare("
        SELECT appointments.*, CONCAT(users.first_name, ' ', users.last_name) AS user_full_name,
               services.name AS service_name, CONCAT(staff.first_name, ' ', staff.last_name) AS staff_full_name
        FROM appointments 
        LEFT JOIN users ON appointments.user_id = users.user_id
        LEFT JOIN services ON appointments.service_id = services.service_id
        LEFT JOIN users AS staff ON appointments.staff_id = staff.user_id
        ORDER BY appointments.appointment_date, appointments.appointment_time
    ");
    $stmt_all->execute();
    $appointments = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
}
?>
<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title"><?= $is_staff ? "Your Appointments Today" : "Manage Appointments" ?></h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li><?= $is_staff ? "Your Appointments Today" : "Manage Appointments" ?></li>
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

    <?php if (!$is_staff): ?>
        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Add Appointment</button>
    <?php endif; ?>

    <h3 class="mt-5">Today's Appointments</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>User</th>
                <th>Service</th>
                <?php if (!$is_staff): ?>
                    <th>Staff</th>
                <?php endif; ?>
                <th>Appointment Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($todays_appointments)): ?>
                <?php foreach ($todays_appointments as $appointment): ?>
                    <tr>
                        <td><?= $appointment['user_full_name'] ?></td>
                        <td><?= $appointment['service_name'] ?></td>
                        <?php if (!$is_staff): ?>
                            <td>
                                <?= !empty($appointment['staff_full_name']) ? $appointment['staff_full_name'] : 'Not Assigned' ?>
                            </td>
                        <?php endif; ?>
                        <td><?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?> <?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                        <td>
                            <select class="form-control" name="status" onchange="updateStatus(this, <?= $appointment['appointment_id'] ?>)">
                                <option value="Accepted" <?= $appointment['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                <option value="In Progress" <?= $appointment['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="Completed" <?= $appointment['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= $appointment['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editAppointmentModal<?= $appointment['appointment_id'] ?>">Edit</button>
                            <a href="delete-appointment.php?appointment_id=<?= $appointment['appointment_id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="editAppointmentModal<?= $appointment['appointment_id'] ?>" tabindex="-1" aria-labelledby="editAppointmentModalLabel<?= $appointment['appointment_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="edit-appointment.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAppointmentModalLabel<?= $appointment['appointment_id'] ?>">Edit Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                                        <div class="form-group">
                                            <label for="appointment_date">Appointment Date</label>
                                            <input type="date" class="form-control" name="appointment_date" value="<?= $appointment['appointment_date'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="appointment_time">Appointment Time</label>
                                            <input type="time" class="form-control" name="appointment_time" value="<?= $appointment['appointment_time'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="service_id">Service</label>
                                            <select class="form-control" name="service_id" required>
                                                <?php 
                                                $stmt_services = $pdo->query("SELECT * FROM services");
                                                while ($service = $stmt_services->fetch(PDO::FETCH_ASSOC)): ?>
                                                    <option value="<?= $service['service_id'] ?>" <?= ($service['service_id'] == $appointment['service_id']) ? 'selected' : '' ?>><?= $service['name'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <?php if (!$is_staff): ?>
                                            <div class="form-group">
                                                <label for="staff_id">Staff</label>
                                                <select class="form-control" name="staff_id">
                                                    <option value="">Not Assigned</option>
                                                    <?php 
                                                    $stmt_staff = $pdo->query("SELECT * FROM users WHERE role = 'staff'");
                                                    while ($staff = $stmt_staff->fetch(PDO::FETCH_ASSOC)): ?>
                                                        <option value="<?= $staff['user_id'] ?>" <?= ($staff['user_id'] == $appointment['staff_id']) ? 'selected' : '' ?>><?= $staff['first_name'] . ' ' . $staff['last_name'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
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
            <?php else: ?>
                <tr><td colspan="6">No appointments for today.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3 class="mt-5">All Appointments</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>User</th>
                <th>Service</th>
                <th>Staff</th>
                <th>Appointment Date & Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= $appointment['user_full_name'] ?></td>
                    <td><?= $appointment['service_name'] ?></td>
                    <td>
                        <?= !empty($appointment['staff_full_name']) ? $appointment['staff_full_name'] : 'Not Assigned' ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?> <?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                    <td>
                        <select class="form-control" name="status" onchange="updateStatus(this, <?= $appointment['appointment_id'] ?>)">
                            <option value="Accepted" <?= $appointment['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                            <option value="In Progress" <?= $appointment['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="Completed" <?= $appointment['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="Cancelled" <?= $appointment['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editAppointmentModal<?= $appointment['appointment_id'] ?>">Edit</button>
                        <a href="delete-appointment.php?appointment_id=<?= $appointment['appointment_id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="add-appointment.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control" name="user_id" required>
                            <?php 
                            $stmt_users = $pdo->query("SELECT * FROM users WHERE role = 'user'");
                            while ($user = $stmt_users->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?= $user['user_id'] ?>"><?= $user['first_name'] . ' ' . $user['last_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_id">Service</label>
                        <select class="form-control" name="service_id" required>
                            <?php 
                            $stmt_services = $pdo->query("SELECT * FROM services");
                            while ($service = $stmt_services->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?= $service['service_id'] ?>"><?= $service['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="staff_id">Staff</label>
                        <select class="form-control" name="staff_id">
                            <option value="">Not Assigned</option>
                            <?php 
                            $stmt_staff = $pdo->query("SELECT * FROM users WHERE role = 'staff'");
                            while ($staff = $stmt_staff->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?= $staff['user_id'] ?>"><?= $staff['first_name'] . ' ' . $staff['last_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" class="form-control" name="appointment_date" required>
                    </div>
                    <div class="form-group">
                        <label for="appointment_time">Appointment Time</label>
                        <input type="time" class="form-control" name="appointment_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ce5" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_appointment" class="btn btn-primary ce5">Add Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(selectElement, appointmentId) {
    var status = selectElement.value;
    $.post('update-status.php', { appointment_id: appointmentId, status: status }, function(response) {
        if (response.success) {
            alert('Appointment status updated successfully.');
        } else {
            alert('Error updating appointment status.');
        }
    }, 'json');
}
</script>

<?php include 'footer.php'; ?>