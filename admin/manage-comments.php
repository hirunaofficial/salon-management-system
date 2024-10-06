<?php 
include 'header.php'; 
include '../dbconnect.php';

// Restrict access for non-admin users
$user_id = $_SESSION['user_id'];
$stmt_role = $pdo->prepare("SELECT role FROM users WHERE user_id = :user_id");
$stmt_role->execute(['user_id' => $user_id]);
$user = $stmt_role->fetch(PDO::FETCH_ASSOC);

if ($user['role'] !== 'admin') {
    echo "<script>alert('Access denied.'); window.location.href = 'index.php';</script>";
    exit;
}

// Fetch all blog posts for the dropdown
$stmt_blog = $pdo->prepare("SELECT id, title FROM blog ORDER BY post_date DESC");
$stmt_blog->execute();
$blogs = $stmt_blog->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Comments</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Comments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">
    <div class="form-group">
        <label for="blogSelector">Select Blog Post:</label>
        <select id="blogSelector" class="form-control">
            <option value="">-- Select Blog Post --</option>
            <?php foreach ($blogs as $blog): ?>
                <option value="<?= $blog['id'] ?>"><?= $blog['title'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <table class="table table-bordered mt-4" id="commentsTable">
        <thead>
            <tr>
                <th>Blog Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" class="text-center">Select a blog post to load comments.</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
document.getElementById('blogSelector').addEventListener('change', function () {
    var blogId = this.value;

    var tableBody = document.querySelector('#commentsTable tbody');
    tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Loading comments...</td></tr>';

    if (blogId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get-comments.php?blog_id=' + blogId, true);
        xhr.onload = function () {
            if (this.status === 200) {
                var response = JSON.parse(this.responseText);
                if (response.success) {
                    tableBody.innerHTML = '';
                    response.comments.forEach(function (comment) {
                        var row = `
                            <tr>
                                <td>${comment.title}</td>
                                <td>${comment.author}</td>
                                <td>${comment.email}</td>
                                <td>${comment.content}</td>
                                <td>${comment.created_at}</td>
                                <td>
                                    <a href="delete-comment.php?id=${comment.id}" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</a>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No comments found for this blog post.</td></tr>';
                }
            }
        };
        xhr.send();
    } else {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Select a blog post to load comments.</td></tr>';
    }
});
</script>

<?php include 'footer.php'; ?>