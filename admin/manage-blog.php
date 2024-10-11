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

// Fetch all blog posts
$stmt = $pdo->prepare("SELECT * FROM blog ORDER BY post_date DESC");
$stmt->execute();
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Blog Posts</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Blog Posts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">
    <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addBlogModal">Add Blog Post</button>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Post Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><img src="../<?= $blog['image'] ?>" alt="Blog Image" style="width:100px;height:60px;"></td>
                    <td><?= $blog['title'] ?></td>
                    <td><?= $blog['category'] ?></td>
                    <td><?= $blog['tags'] ?></td>
                    <td><?= date('F d, Y', strtotime($blog['post_date'])) ?></td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editBlogModal<?= $blog['id'] ?>">Edit</button>
                        <a href="delete-blog.php?id=<?= $blog['id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                    </td>
                </tr>

                <div class="modal fade" id="editBlogModal<?= $blog['id'] ?>" tabindex="-1" aria-labelledby="editBlogModalLabel<?= $blog['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="edit-blog.php" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBlogModalLabel<?= $blog['id'] ?>">Edit Blog Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" name="title" value="<?= $blog['title'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $blog['category'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tags">Tags</label>
                                        <input type="text" class="form-control" name="tags" value="<?= $blog['tags'] ?>" placeholder="Comma-separated tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea class="form-control" name="content" required><?= $blog['content'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <img src="../<?= $blog['image'] ?>" alt="Current Blog Image" style="width:100px;height:60px;margin-top:10px;">
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
</div>

<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="add-blog.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBlogModalLabel">Add New Blog Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" name="category" required>
                    </div>
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" class="form-control" name="tags" placeholder="Comma-separated tags" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" name="content" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_blog" class="btn btn-primary ce5">Add Blog Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('added') && urlParams.get('added') === 'success') {
        alert('Blog post added successfully!');
    }

    if (urlParams.has('updated') && urlParams.get('updated') === 'success') {
        alert('Blog post updated successfully!');
    }

    if (urlParams.has('deleted') && urlParams.get('deleted') === 'success') {
        alert('Blog post deleted successfully!');
    }

    if (urlParams.has('mail') && urlParams.get('mail') === 'failed') {
        alert('Blog post added, but failed to send notification email.');
    }
</script>

<?php include 'footer.php'; ?>