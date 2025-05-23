<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

echo "Logo Path: " . htmlspecialchars($settings['logo_path'] ?? 'assets/img/logo.png'); 
echo "<br>Full URL: " . BASE_URL . '/' . htmlspecialchars($settings['logo_path'] ?? 'assets/img/logo.png');

// Get all active industries
$industries = $db->fetchAll("SELECT * FROM industries WHERE is_active = 1 ORDER BY name");

// Get site settings for industries description
$settings = $db->fetchOne("SELECT industries_description FROM site_settings LIMIT 1");
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industries We Serve - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">

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
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="industries-hero">
        <div class="container">
            <h1>Industries We Serve</h1>
            <p>Providing solutions across multiple sectors with our specialized products</p>
        </div>
    </section>

    <div class="container-fluid industries-section">
        <div class="content-box">
            <h2>Industries <span>Served</span></h2>
            <p><?php echo htmlspecialchars($settings['industries_description'] ?? 'Each year, hundreds of clients across the country rely on our expertise.'); ?></p>
            
            <div class="row mt-5">
                <?php foreach ($industries as $industry): ?>
                <div class="col-md-4 mb-4">
                    <div class="industry-card">
                        <?php if ($industry['image_path']): ?>
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($industry['image_path']); ?>" alt="<?php echo htmlspecialchars($industry['name']); ?>">
                        <?php endif; ?>
                        <div class="industry-content">
                            <h3><?php echo htmlspecialchars($industry['name']); ?></h3>
                            <p><?php echo htmlspecialchars($industry['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Include all your JS files -->
    <script src="assets/js/main.js"></script>
</body>
</html>