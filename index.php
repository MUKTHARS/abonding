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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <title><?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?> - Home</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css"></head>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/home.css">
<body>
    <header class="header" id="header">
    <nav class="navbar container">
        <section class="navbar__left">
            <a href="<?php echo BASE_URL; ?>" class="brand" style="text-decoration: none;color:#019626;font-weight:700;font-size: 20px;">
                <img src="<?php echo BASE_URL . '/' . htmlspecialchars($settings['logo_path'] ?? 'assets/img/logo.png'); ?>" style="height:45px"/>
                <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?>
            </a>
        </section>
        
        <section class="navbar__center">
            <ul class="nav__links">
                <li><a href="<?php echo BASE_URL; ?>" class="active">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>/about.php">About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>/productrange.php">Product Range</a></li>
                <li><a href="<?php echo BASE_URL; ?>/industries.php">Industries</a></li>
                <li><a href="<?php echo BASE_URL; ?>/contact.php">Contact Us</a></li>
            </ul>
        </section>
        
        <section class="navbar__right">
            <div class="search-box">
                <form action="<?php echo BASE_URL; ?>/search.php" method="get">
                    <input type="text" name="q" placeholder="Search..." class="search-input">
                    <button type="submit" class="search-button">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </section>
        
        <div class="mobile-menu-toggle">
            <i class="bi bi-list"></i>
        </div>
    </nav>
</header>

<style>
    /* Header Styles */
    .header {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }
    
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
    }
    
    .nav__links {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .nav__links li {
        margin: 0 15px;
    }
    
    .nav__links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .nav__links a:hover, 
    .nav__links a.active {
        color: #019626;
    }
    
    .search-box {
        display: flex;
        align-items: center;
    }
    
    .search-input {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
        outline: none;
    }
    
    .search-button {
        background-color: #019626;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
    }
    
    .mobile-menu-toggle {
        display: none;
        font-size: 24px;
        cursor: pointer;
    }
    
    @media (max-width: 992px) {
        .nav__links {
            display: none;
        }
        
        .search-box {
            display: none;
        }
        
        .mobile-menu-toggle {
            display: block;
        }
    }
</style>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.mobile-menu-toggle');
        const navLinks = document.querySelector('.nav__links');
        
        toggle.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar') && window.innerWidth <= 992) {
                navLinks.style.display = 'none';
            }
        });
    });
</script>

   <section class="hero-slider hero-style">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($sliders as $slider): ?>
            <div class="swiper-slide">
                <div class="slide-inner slide-bg-image" style="background-image: url('<?php echo BASE_URL . '/' . htmlspecialchars($slider['image_path']); ?>')">
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
                <div class="col-md-3 col-6"><a href="<?php echo BASE_URL; ?>/productrange.php" class="btn-custom btn">View More</a></div>
            </div>
            <div class="row">
                <?php foreach ($productCategories as $category): ?>
                <div class="col-md-3 px-3">
                    <div class="cardproducts">
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>/productrange.php" class="learn-more">LEARN MORE <i class="bi bi-link-45deg"></i></a>
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
 <script >
    // In your script.js or at the bottom of index.php
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        speed: 1000,
        parallax: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
 </script>
</body>
</html>