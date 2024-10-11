<?php include 'header.php'; ?>
<?php include 'dbconnect.php'; ?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Blog</h2>
                    <ul>
                        <li><a class="active" href="#">Home</a></li>
                        <li>Blog</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="our-blog-area" class="our-blog-area ptb-90 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    $limit = 6;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Check if there's a search query
                    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

                    // If search query exists, modify the SQL query
                    if ($query) {
                        $stmt_total = $pdo->prepare("SELECT COUNT(*) as total_blogs FROM blog WHERE title LIKE :query OR content LIKE :query");
                        $stmt_total->execute(['query' => '%' . $query . '%']);
                        $total_blogs = $stmt_total->fetch(PDO::FETCH_ASSOC)['total_blogs'];

                        // Fetch blog posts matching the query with comment counts
                        $stmt = $pdo->prepare("
                            SELECT b.*, COUNT(c.id) as comments_count 
                            FROM blog b
                            LEFT JOIN comments c ON b.id = c.blog_id 
                            WHERE b.title LIKE :query OR b.content LIKE :query 
                            GROUP BY b.id 
                            ORDER BY b.post_date DESC 
                            LIMIT :limit OFFSET :offset
                        ");
                        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                    } else {
                        // Fetch total blog count and blog posts for the current page (no query)
                        $stmt_total = $pdo->prepare("SELECT COUNT(*) as total_blogs FROM blog");
                        $stmt_total->execute();
                        $total_blogs = $stmt_total->fetch(PDO::FETCH_ASSOC)['total_blogs'];

                        // Fetch blog posts for the current page with comment counts
                        $stmt = $pdo->prepare("
                            SELECT b.*, COUNT(c.id) as comments_count 
                            FROM blog b
                            LEFT JOIN comments c ON b.id = c.blog_id 
                            GROUP BY b.id 
                            ORDER BY b.post_date DESC 
                            LIMIT :limit OFFSET :offset
                        ");
                        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                    }

                    $stmt->execute();
                    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($blogs) === 0) {
                        echo "<p>No results found for <strong>$query</strong></p>";
                    }

                    foreach ($blogs as $blog) {
                    ?>
                        <div class="col-lg-6 col-md-6">
                            <div class="single-blog-wrap mb-30">
                                <div class="blog-front">
                                    <div class="blog-thumb">
                                        <img src="<?= $blog['image'] ?>" alt="blog images">
                                    </div>
                                    <div class="blog-hover-info">
                                        <div class="blog-hover-action">
                                            <a href="blog-details.php?id=<?= $blog['id'] ?>"><i class="zmdi zmdi-link"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="blog-details">
                                    <h4 class="blog-title"><a href="blog-details.php?id=<?= $blog['id'] ?>"><?= $blog['title'] ?></a></h4>
                                    <ul class="blog-post-date">
                                        <li class="post-time"><i class="zmdi zmdi-time"></i><span><?= date('M d, Y', strtotime($blog['post_date'])) ?></span></li>
                                        <li class="post-cmt"><i class="zmdi zmdi-comment-alt-text"></i><span>(<?= $blog['comments_count'] ?>)</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="page text-center page-res">
                    <ul>
                        <?php
                        $total_pages = ceil($total_blogs / $limit);

                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($i == $page) ? 'class="active"' : '';
                            $query_string = $query ? "&query=" . urlencode($query) : '';
                            echo "<li $active_class><a href='blog.php?page=$i$query_string'>$i</a></li>";
                        }

                        if ($page < $total_pages) {
                            $next_page = $page + 1;
                            echo "<li class='p-icon'><a href='blog.php?page=$next_page$query_string'><i class='zmdi zmdi-long-arrow-right'></i></a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="blog-right-sidebar">
                    <div class="blog-search mb-60">
                        <h3 class="leave-comment-text">Search</h3>
                        <form action="blog.php" method="GET">
                            <input value="<?= htmlentities($query) ?>" name="query" placeholder="Search" type="text">
                            <button class="submit" type="submit"><i class="zmdi zmdi-search"></i></button>
                        </form>
                    </div>

                    <div class="blog-right-sidebar-top mb-60">
                        <h3 class="leave-comment-text">Recent posts</h3>
                        <div class="blog-sitebar-video">
                            <?php
                            $recent_stmt = $pdo->prepare("SELECT * FROM blog ORDER BY post_date DESC LIMIT 4");
                            $recent_stmt->execute();
                            $recent_posts = $recent_stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($recent_posts as $recent) {
                            ?>
                            <div class="single-site-video">
                                <div class="blog-video-img">
                                    <a href="blog-details.php?id=<?= $recent['id'] ?>"><img src="<?= $recent['image'] ?>" alt="<?= $recent['title'] ?>"></a>
                                </div>
                                <div class="blog-video-text">
                                    <h3><a href="blog-details.php?id=<?= $recent['id'] ?>"><?= $recent['title'] ?></a></h3>
                                    <span><?= date('d M, Y', strtotime($recent['post_date'])) ?></span>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="blog-right-sidebar-top mb-60">
                        <h3 class="leave-comment-text">Categories</h3>
                        <ul>
                            <?php
                            $stmt_categories = $pdo->prepare("SELECT category, COUNT(*) as count FROM blog GROUP BY category");
                            $stmt_categories->execute();
                            $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($categories as $category) {
                                echo '<li><a href="blog.php?category=' . urlencode($category['category']) . '">' . $category['category'] . ' <span>(' . $category['count'] . ')</span></a></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="blog-right-sidebar-bottom">
                        <h3 class="leave-comment-text">Tags</h3>
                        <ul>
                            <?php
                            $stmt_tags = $pdo->prepare("SELECT DISTINCT tags FROM blog");
                            $stmt_tags->execute();
                            $tags = $stmt_tags->fetchAll(PDO::FETCH_ASSOC);

                            $all_tags = [];
                            foreach ($tags as $tag_row) {
                                $tag_list = explode(',', $tag_row['tags']);
                                $all_tags = array_merge($all_tags, $tag_list);
                            }

                            $unique_tags = array_unique($all_tags);
                            foreach ($unique_tags as $tag) {
                                echo '<li><a href="blog.php?tag=' . urlencode(trim($tag)) . '">' . trim($tag) . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>