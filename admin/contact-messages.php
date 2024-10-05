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

// Fetch all contact messages
$stmt = $pdo->prepare("SELECT * FROM contact_messages ORDER BY submitted_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Contact Messages</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Contact Messages</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?= htmlspecialchars($message['name']) ?></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= htmlspecialchars($message['phone']) ?></td>
                    <td><?= htmlspecialchars($message['subject']) ?></td>
                    <td><?= htmlspecialchars($message['message']) ?></td>
                    <td><?= $message['submitted_at'] ?></td>
                    <td>
                        <a href="delete-contact-message.php?id=<?= $message['id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>