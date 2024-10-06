<?php
include 'header.php';
include 'dbconnect.php';
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Products</h2>
                    <ul>
                        <li><a class="active" href="index.php">Home</a></li>
                        <li>Products</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="top-shop-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop-around">
                    <div class="all-shop2-area ptb-20">
                        <h3 class="leave-comment-text">Price</h3>
                        <div class="widget shop-filter">
                            <div class="price_filter">
                                <div id="slider-range"></div>
                                <div class="price_slider_amount">
                                    <form id="price-filter-form" method="GET" action="">
                                        <input type="text" id="amount" name="price" readonly />
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="blog-search mt-40 mb-60">
                            <h3 class="leave-comment-text">Search</h3>
                            <form action="" method="GET">
                                <input value="" placeholder="Search" type="text" name="query">
                                <button class="submit" type="submit"><i class="zmdi zmdi-search"></i></button>
                            </form>
                        </div>

                        <div class="blog-right-sidebar-top mb-60">
                            <h3 class="leave-comment-text">Categories</h3>
                            <ul>
                                <?php
                                $sql_categories = "SELECT category, COUNT(*) AS count FROM products GROUP BY category";
                                $stmt_categories = $pdo->query($sql_categories);
                                $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categories as $category) {
                                    echo "<li><a href='?category=" . urlencode($category['category']) . "'>" . ucfirst($category['category']) . " <span>(" . $category['count'] . ")</span></a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="features-tab fe-again">
                            <div class="shop-all-tab top-shop-n">
                                <div class="two-part an-tw">
                                    <ul class="nav tabs" role="tablist">
                                        <li role="presentation"><a class="active" href="#home" aria-controls="home" role="tab" data-bs-toggle="tab">Grid</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-bs-toggle="tab">List</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <div class="row">
                                        <?php
                                        $limit = 9;
                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $limit;

                                        $query = "SELECT product_id, product_name, description, price, image_url, stock_status FROM products WHERE 1";

                                        if (!empty($_GET['query'])) {
                                            $search = htmlspecialchars($_GET['query']);
                                            $query .= " AND product_name LIKE '%$search%'";
                                        }

                                        if (!empty($_GET['category'])) {
                                            $category = htmlspecialchars($_GET['category']);
                                            $query .= " AND category = '$category'";
                                        }

                                        if (!empty($_GET['price'])) {
                                            $price = explode('-', $_GET['price']);
                                            $min_price = (float) $price[0];
                                            $max_price = (float) $price[1];
                                            $query .= " AND price BETWEEN $min_price AND $max_price";
                                        }

                                        $query .= " LIMIT $limit OFFSET $offset";
                                        $stmt = $pdo->query($query);
                                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($products) {
                                            foreach ($products as $product) {
                                                $is_out_of_stock = ($product['stock_status'] === 'out_of_stock');
                                        ?>
                                        <div class="col-lg-4 col-md-6 mb-30">
                                            <div class="hs-single-shop-area mb-30">
                                                <div class="single-shop-thumd">
                                                    <img src="<?php echo $product['image_url']; ?>" alt="product images">
                                                    <div class="product-information">
                                                        <ul>
                                                            <li>
                                                                <?php if ($is_out_of_stock): ?>
                                                                    <a href="#" onclick="alert('This product is out of stock and cannot be added to the cart.'); return false;">
                                                                        <i class="zmdi zmdi-shopping-cart"></i>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <form action="cart.php" method="post">
                                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                                        <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                                                        <input type="hidden" name="price" value="<?php echo $product['price'], 2; ?>">
                                                                        <input type="hidden" name="qty" value="1">
                                                                        <a><button type="submit" name="add_to_cart" style="border: none; background: none;">
                                                                            <i class="zmdi zmdi-shopping-cart"></i>
                                                                        </button></a>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </li>

                                                            <li>
                                                                <form action="wishlist.php" method="post">
                                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                                    <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                                                    <input type="hidden" name="price" value="<?php echo $product['price'], 2; ?>">
                                                                    <input type="hidden" name="qty" value="1">
                                                                    <a><button type="submit" name="wishlist" style="border: none; background: none;">
                                                                        <i class="zmdi zmdi-favorite"></i>
                                                                    </button></a>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="hs-shop-details">
                                                    <h4 class="shop-title"><a href="#"><?php echo $product['product_name']; ?></a></h4>
                                                    <ul class="product-price">
                                                        <li class="new-price">LKR <?php echo number_format($product['price'], 2); ?></li>
                                                        <?php if ($is_out_of_stock): ?>
                                                            <li style="color: red;">Out of Stock</li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        } else {
                                            echo "<p>No products found.</p>";
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <div class="sho">
                                        <?php
                                        if ($products) {
                                            foreach ($products as $product) {
                                                $is_out_of_stock = ($product['stock_status'] === 'out_of_stock');
                                        ?>
                                        <div class="row hs-single-shop-area shop-over mb-30">
                                            <div class="col-lg-4 col-md-4 col-shop">
                                                <div class="single-shop-thumd">
                                                    <img src="<?php echo $product['image_url']; ?>" alt="product images">
                                                    <div class="product-information">
                                                        <ul>
                                                            <?php if ($is_out_of_stock): ?>
                                                                <li><a href="#" onclick="alert('This product is out of stock and cannot be added to the cart.'); return false;"><i class="zmdi zmdi-shopping-cart"></i></a></li>
                                                            <?php else: ?>
                                                                <li>
                                                                    <form action="cart.php" method="post">
                                                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                                        <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                                                                        <input type="hidden" name="price" value="<?php echo $product['price'], 2; ?>">
                                                                        <input type="hidden" name="qty" value="1">
                                                                        <button type="submit" name="add_to_cart" style="border: none; background: none;">
                                                                            <a><i class="zmdi zmdi-shopping-cart"></i></a>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            <?php endif; ?>
                                                            <li><a href="#"><i class="zmdi zmdi-favorite"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-8 col-shop">
                                                <div class="hs-shop-details">
                                                    <h4 class="shop-title"><a href="#"><?php echo $product['product_name']; ?></a></h4>
                                                    <p><?php echo $product['description']; ?></p>
                                                    <ul class="product-price">
                                                        <li class="new-price">LKR <?php echo number_format($product['price'], 2); ?></li>
                                                        <?php if ($is_out_of_stock): ?>
                                                            <li style="color: red;">Out of Stock</li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                        } else {
                                            echo "<p>No products found.</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="page text-center">
                                <ul>
                                    <?php
                                    $count_query = "SELECT COUNT(*) AS total FROM products WHERE 1";
                                    if (!empty($_GET['query'])) {
                                        $count_query .= " AND product_name LIKE '%$search%'";
                                    }
                                    if (!empty($_GET['category'])) {
                                        $count_query .= " AND category = '$category'";
                                    }
                                    if (!empty($_GET['price'])) {
                                        $count_query .= " AND price BETWEEN $min_price AND $max_price";
                                    }

                                    $count_stmt = $pdo->query($count_query);
                                    $total_products = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
                                    $total_pages = ceil($total_products / $limit);

                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? 'class="active"' : '';
                                        echo "<li $active><a href='?page=$i'>" . str_pad($i, 2, '0', STR_PAD_LEFT) . "</a></li>";
                                    }
                                    ?>
                                    <li class="p-icon"><a href="?page=<?php echo min($page + 1, $total_pages); ?>"><i class="zmdi zmdi-long-arrow-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>