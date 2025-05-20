<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Get site settings
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");

// Get active sliders
$sliders = $db->fetchAll("SELECT * FROM sliders WHERE is_active = 1 ORDER BY display_order");

// Get product categories (limit to 4 for homepage)
$productCategories = $db->fetchAll("SELECT * FROM product_categories WHERE is_active = 1 LIMIT 4");

// Get industries served
$industries = $db->fetchAll("SELECT * FROM industries WHERE is_active = 1");

// Get awards
$awards = $db->fetchAll("SELECT * FROM awards WHERE is_active = 1 LIMIT 4");

// Get statistics
$statistics = $db->fetchAll("SELECT * FROM statistics WHERE is_active = 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
    <title><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?> - Home</title>
    <!-- Rest of head -->
</head>
<body>
    <header class="header" id="header">
        <nav class="navbar container">
            <section class="navbar__left">
                <a href="<?php echo BASE_URL; ?>" class="brand" style="text-decoration: none;color:#019626;font-weight:700;font-size: 20px;">
                    <img src="<?php echo BASE_URL . '/' . htmlspecialchars($settings['logo_path'] ?? 'assets/img/logo.png'); ?>" style="height:45px"/>
                    <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?>
                </a>
                <!-- Rest of header -->
            </section>
        </nav>
    </header>

    <section class="hero-slider hero-style">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($sliders as $slider): ?>
                <div class="swiper-slide">
                    <div class="slide-inner slide-bg-image" data-background="<?php echo BASE_URL . '/' . htmlspecialchars($slider['image_path']); ?>">
                        <div class="container">
                            <div data-swiper-parallax="400" class="slide-text">
                                <p class="whitefont"><?php echo htmlspecialchars($slider['description']); ?></p>
                            </div>
                            <div class="clearfix"></div>
                            <div data-swiper-parallax="500" class="slide-btns">
                                <a href="<?php echo htmlspecialchars($slider['button_link']); ?>" class="theme-btn-s2"><?php echo htmlspecialchars($slider['button_text'] ?? 'Read More'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <section>
        <div class="container py-5">
            <div class="row mb-5 justify-content-between">
                <div class="col-md-6 col-12"><h3>Trending <span>Products</span></h3></div>
                <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>/productrange" class="btn-custom btn">View More</a></div>
            </div>
            <div class="row">
                <?php foreach ($productCategories as $category): ?>
                <div class="col-md-3 px-3">
                    <div class="cardproducts">
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>/productrange" class="learn-more">LEARN MORE <i class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Industries Section (similar dynamic approach) -->
    <div style="background: url('4.jpg') no-repeat center center/cover;color:black;font-family: Arial, sans-serif;">
        <div class="container-fluid industries-section">
            <div class="content-box">
                <h2>Industries <span>Served</span></h2>
                <p><?php echo htmlspecialchars($settings['industries_description'] ?? 'Default description'); ?></p>
                <ul class="industry-list">
                    <?php foreach ($industries as $industry): ?>
                    <li><?php echo htmlspecialchars($industry['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Awards Section -->
    <section>
        <div class="container">
            <div class="title-container mb-5">
                <h2 class="section-title">Our <span>Awards</span></h2>
                <div class="underline"></div>
            </div>
        </div>
        <div class="px-3">
            <div class="row">
                <?php foreach ($awards as $award): ?>
                <div class="col-md-3 px-3">
                    <div class="cardindustries">
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($award['image_path']); ?>" alt="<?php echo htmlspecialchars($award['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($award['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($award['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section>
        <div class="container-fluid bg-success">
            <div class="container pb-4 text-white text-bold">
                <h1 class="text-center py-5">Our <span>Figures</span></h1>
                <div class="row mt-4">
                    <?php foreach ($statistics as $stat): ?>
                    <div class="col-md-4 text-center mb-3 col-md-offset-2">
                        <h1><span class="counter"><?php echo htmlspecialchars($stat['value']); ?></span><?php echo strpos($stat['value'], 'Cr') !== false ? '' : '+'; ?></h1>
                        <p><?php echo htmlspecialchars($stat['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (similar dynamic approach) -->
    <footer>
        <div class="up-section">
            <a href="#" class="f-logo"><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></a>
            <!-- Rest of footer -->
        </div>
        <p class="copyright"><span class="f-logo"><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></span>Copyright <?php echo date('Y'); ?></p>
    </footer>

    <!-- Floating contact buttons -->
    <div class="bodydiv">
        <div class="btn-group my mb-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success"><i class="bi my bi-whatsapp"></i></button>
            <a href="https://wa.me/<?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '919442576397'); ?>" target="_blank" type="button" class="btn btn-light">Whatsapp:<br><?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+91 94425 76397'); ?></a>
        </div>
        <div class="btn-group my" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success"><i class="bi my bi-telephone-fill"></i></button>
            <a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+919442576397'); ?>" type="button" class="btn btn-light">Call:<br><?php echo htmlspecialchars($settings['contact_phone'] ?? '+91 94425 76397'); ?></a>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
    <!-- Your existing scripts -->
</body>
</html>