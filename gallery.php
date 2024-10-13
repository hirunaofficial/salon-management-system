<?php include 'header.php'; ?>
<?php include 'dbconnect.php'; ?>

<section class="breadcrumbs-area ptb-100 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">our gallery</h2>
                    <ul>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                        <li>gallery</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="hs-portfolio-area" class="hs-portfolio-area ptb-90 bg-white">
    <div class="container">
        <div class="row mb-50 xmb-20">
            <div class="col-12 text-center">
                <ul id="gallery-filters" class="port-filter-nav">
                    <li data-filter="*" class="is-checked">All</li>

                    <?php
                    $stmt_categories = $pdo->prepare("SELECT DISTINCT category FROM gallery");
                    $stmt_categories->execute();
                    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through each category and generate a filter button
                    foreach ($categories as $category) {
                        $category_class = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $category['category']));
                        echo '<li data-filter=".' . $category_class . '">' . ucfirst($category['category']) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="row our-portfolio-page grid">
            <?php
            $stmt = $pdo->prepare("SELECT * FROM gallery");
            $stmt->execute();
            $gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through gallery items and display them
            foreach ($gallery_items as $item) {
                $category_class = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $item['category']));
            ?>

            <div class="pro-item col-lg-4 col-md-4 col-xl-4 <?= $category_class ?>">
                <div class="our-portfolio" data-title-position="left, top">
                    <div class="our-port-thumb">
                        <img src="<?= $item['file_path'] ?>" alt="<?= $item['title'] ?>">
                    </div>
                    <div class="our-hover-information">
                        <div class="our-hover-action">
                            <a href="<?= $item['file_path'] ?>" data-lightbox="hsportimg" data-title="<?= $item['title'] ?>">
                                <i class="zmdi zmdi-zoom-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>