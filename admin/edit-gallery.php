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

// Handle adding a new gallery image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_gallery'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];

    // Image upload logic
    $target_dir = "../images/gallery/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        echo "<script>alert('File is not an image.');</script>";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        echo "<script>alert('File already exists.');</script>";
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000) { // 500KB limit
        $uploadOk = 0;
        echo "<script>alert('Sorry, your file is too large.');</script>";
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
        echo "<script>alert('Only JPG, JPEG, PNG files are allowed.');</script>";
    }

    // Check if everything is ok before uploading
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert into the gallery table
            $stmt = $pdo->prepare("INSERT INTO gallery (title, category, file_path) VALUES (:title, :category, :file_path)");
            $stmt->execute(['title' => $title, 'category' => $category, 'file_path' => 'images/gallery/' . basename($_FILES["file"]["name"])]);
            echo "<script>alert('Gallery image added successfully!'); window.location.href = 'edit-gallery.php';</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    }
}

// Handle editing gallery images
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_gallery'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $current_file_path = $_POST['current_file_path'];

    // Image upload logic (if a new file is uploaded)
    if (!empty($_FILES["file"]["name"])) {
        $target_dir = "../images/gallery/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            echo "<script>alert('File is not an image.');</script>";
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
            echo "<script>alert('File already exists.');</script>";
        }

        // Check file size
        if ($_FILES["file"]["size"] > 500000) { // 500KB limit
            $uploadOk = 0;
            echo "<script>alert('Sorry, your file is too large.');</script>";
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
            echo "<script>alert('Only JPG, JPEG, PNG files are allowed.');</script>";
        }

        // Check if everything is ok before uploading
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $new_file_path = 'images/gallery/' . basename($_FILES["file"]["name"]);

                // Update the database
                $stmt = $pdo->prepare("UPDATE gallery SET title = :title, category = :category, file_path = :file_path WHERE id = :id");
                $stmt->execute(['title' => $title, 'category' => $category, 'file_path' => $new_file_path, 'id' => $id]);

                // Optionally, delete the old file if needed
                if ($current_file_path != $new_file_path && file_exists("../" . $current_file_path)) {
                    unlink("../" . $current_file_path);
                }

                echo "<script>alert('Gallery image updated successfully!'); window.location.href = 'edit-gallery.php';</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    } else {
        // Update the database without changing the image
        $stmt = $pdo->prepare("UPDATE gallery SET title = :title, category = :category WHERE id = :id");
        $stmt->execute(['title' => $title, 'category' => $category, 'id' => $id]);

        echo "<script>alert('Gallery image updated successfully!'); window.location.href = 'edit-gallery.php';</script>";
    }
}

// Handle deleting gallery images
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Fetch the file path before deletion
    $stmt = $pdo->prepare("SELECT file_path FROM gallery WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $gallery = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete from the database
    $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Delete the file from the directory
    if (file_exists("../" . $gallery['file_path'])) {
        unlink("../" . $gallery['file_path']);
    }

    echo "<script>alert('Gallery image deleted successfully!'); window.location.href = 'edit-gallery.php';</script>";
}

// Fetch all gallery images
$stmt = $pdo->prepare("SELECT * FROM gallery ORDER BY category ASC");
$stmt->execute();
$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Gallery</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Gallery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ptb-100">
    <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addGalleryModal">Add Gallery Image</button>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gallery as $image): ?>
                <tr>
                    <td><?= $image['title'] ?></td>
                    <td><?= $image['category'] ?></td>
                    <td><img src="../<?= $image['file_path'] ?>" alt="<?= $image['title'] ?>" style="width: 80px;"></td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editGalleryModal<?= $image['id'] ?>">Edit</button>
                        <a href="edit-gallery.php?delete=<?= $image['id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
                    </td>
                </tr>

                <div class="modal fade" id="editGalleryModal<?= $image['id'] ?>" tabindex="-1" aria-labelledby="editGalleryModalLabel<?= $image['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editGalleryModalLabel<?= $image['id'] ?>">Edit Gallery Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $image['id'] ?>">
                                    <input type="hidden" name="current_file_path" value="<?= $image['file_path'] ?>">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" name="title" value="<?= $image['title'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $image['category'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Image (Optional)</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="edit_gallery" class="btn btn-primary ce5">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGalleryModalLabel">Add New Gallery Image</h5>
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
                        <label for="file">Image</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_gallery" class="btn btn-primary ce5">Add Gallery Image</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>