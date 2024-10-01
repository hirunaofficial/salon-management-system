<?php
include 'header.php';
include 'dbconnect.php';

// Query to fetch unique categories from the services table
$stmt = $pdo->prepare("SELECT DISTINCT category FROM services");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to fetch all services from the database
$stmt_services = $pdo->prepare("SELECT * FROM services");
$stmt_services->execute();
$services = $stmt_services->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="breadcrumbs-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="breadcrumbs">
                    <h2 class="page-title">Services</h2>
                    <ul>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                        <li>Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="services-filter-area ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <ul id="service-filters" class="port-filter-nav">
                    <li data-filter="*" class="is-checked">All</li>
                    <?php foreach ($categories as $category): ?>
                        <li data-filter=".<?= strtolower(str_replace(' ', '-', $category['category'])) ?>"><?= ucfirst($category['category']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="hs-service-area" class="hs-service area ptb-90 bg-gray">
    <div class="container">
        <div class="row mb-n6 grid">
            <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6 mb-6 pro-item <?= strtolower(str_replace(' ', '-', $service['category'])) ?>">
                    <div class="single-service-area">
                        <h4 class="ser-vice-tit"><?= $service['name'] ?></h4>
                        <p class="ser-pra"><?= $service['description'] ?></p>
                        <p class="service-price">Price: LKR <?= number_format($service['price'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>