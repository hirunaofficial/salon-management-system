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

// Fetch all products
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Manage Products</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Manage Products</li>
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

    <!-- Button to trigger Add Product Modal -->
    <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="../<?= $product['image_url'] ?>" alt="<?= $product['product_name'] ?>" class="img-thumbnail" width="100">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= $product['product_name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td><?= $product['category'] ?></td>
                    <td><?= $product['price'] ?></td>
                    <td><?= ucfirst($product['stock_status']) ?></td>
                    <td>
                        <button class="btn btn-primary ce5" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $product['product_id'] ?>">Edit</button>
                        <a href="delete-product.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary ce5" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProductModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="edit-product.php" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel<?= $product['product_id'] ?>">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" name="product_name" value="<?= $product['product_name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description"><?= $product['description'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" class="form-control" name="category" value="<?= $product['category'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" value="<?= $product['price'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock_status">Stock Status</label>
                                        <select class="form-control" name="stock_status">
                                            <option value="in_stock" <?= ($product['stock_status'] == 'in_stock') ? 'selected' : '' ?>>In Stock</option>
                                            <option value="out_of_stock" <?= ($product['stock_status'] == 'out_of_stock') ? 'selected' : '' ?>>Out of Stock</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Product Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <?php if (!empty($product['image_url'])): ?>
                                            <img src="../<?= $product['image_url'] ?>" class="img-thumbnail mt-2" width="100">
                                            <input type="hidden" name="current_image_url" value="<?= $product['image_url'] ?>">
                                        <?php endif; ?>
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

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="add-product.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="category">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="stock_status">Stock Status</label>
                            <select class="form-control" name="stock_status">
                                <option value="in_stock">In Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Product Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary ce5" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_product" class="btn btn-primary ce5">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
