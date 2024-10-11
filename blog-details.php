<?php include 'header.php'; ?>
<?php include 'dbconnect.php'; ?>

<?php
// Fetch blog details by ID
$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare("SELECT * FROM blog WHERE id = :id");
$stmt->execute(['id' => $blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch comments related to the blog
$comments_stmt = $pdo->prepare("SELECT * FROM comments WHERE blog_id = :blog_id ORDER BY created_at DESC");
$comments_stmt->execute(['blog_id' => $blog_id]);
$comments = $comments_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title"><?= $blog['title'] ?></h2>
                    <ul>
                        <li><a class="active" href="#">Home</a></li>
                        <li><a class="active" href="#">Blog</a></li>
                        <li><?= $blog['title'] ?></li>
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
                <div class="blog-details-left">
                    <div class="blog-part">
                        <img src="<?= $blog['image'] ?>" alt="news">
                        <div class="blog-info mt-20">
                            <h3><?= $blog['title'] ?></h3>
                            <p><?= $blog['content'] ?></p>
                        </div>
                    </div>

                    <div class="news-details-bottom mtb-60">
                        <h3 class="leave-comment-text">Comments</h3>

                        <?php if (empty($comments)): ?>
                            <p>No comments yet.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>

                            <div class="blog-top ptb-20">
                                <div class="news-allreply">
                                    <a href="#"><img src="images/blog/user.jpg" alt=""></a>
                                </div>
                                <div class="blog-img-details">
                                    <div class="blog-title">
                                        <h3><?= $comment['author'] ?></h3>
                                        <span><?= date('d F, Y h:i A', strtotime($comment['created_at'])) ?></span>
                                    </div>
                                    <p class="p-border"><?= $comment['content'] ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="leave-comment">
                        <h3 class="leave-comment-text">Write a comment</h3>
                        <form action="submit_comment.php" method="POST">
                            <input type="hidden" name="blog_id" value="<?= $blog_id ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="leave-form">
                                        <input name="author" placeholder="Name*" type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="leave-form">
                                        <input name="email" placeholder="Email*" type="email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-leave">
                                        <textarea name="content" placeholder="Comment*" required></textarea>
                                        <button class="submit" type="submit">Send Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="blog-right-sidebar">
                    <div class="blog-search mb-60">
                        <h3 class="leave-comment-text">Search</h3>
                        <form action="blog.php" method="GET">
                            <input name="query" placeholder="Search" type="text">
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