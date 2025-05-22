<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get all product categories
$categories = $db->fetchAll("SELECT * FROM product_categories WHERE is_active = 1 ORDER BY name");

// Get products for each category
foreach ($categories as &$category) {
    $category['products'] = $db->fetchAll("
        SELECT * FROM products 
        WHERE category_id = ? AND is_active = 1 
        ORDER BY name
    ", [$category['id']]);
}
unset($category); // Break the reference
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Range - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
    <style>
        /* Additional styles for product range page */
        .product-range-section {
            padding: 60px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .section-title span {
            color: #019626;
        }
        
        .underline {
            width: 100px;
            height: 3px;
            background: #019626;
            margin: 15px auto 30px;
        }
        
        .category-title {
            font-size: 1.8rem;
            color: #019626;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        
        .cardproducts {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            height: 100%;
            margin-bottom: 20px;
        }
        
        .cardproducts:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .cardproducts img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        
        .card-text {
            color: #666;
            margin-bottom: 15px;
        }
        
        .learn-more {
            color: #019626;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }
        
        .learn-more i {
            margin-left: 5px;
        }
        
        .btn-custom {
            background-color: #019626;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        
        .btn-custom:hover {
            background-color: #017a1f;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="product-range-section">
        <div class="container py-5">
            <div class="row mb-5 justify-content-between">
                <div class="col-md-6 col-12">
                    <h2 class="section-title">Our <span>Product Range</span></h2>
                </div>
                <div class="col-md-3 col-6">
                    <a href="<?php echo BASE_URL; ?>/productrange" class="btn btn-custom">View All</a>
                </div>
            </div>
            
            <div class="row">
                <?php foreach ($categories as $category): ?>
                <div class="col-md-3 px-3">
                    <div class="cardproducts">
                        <?php if ($category['image_path']): ?>
                        <img src="<?php echo htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="<?php echo BASE_URL; ?>/productdetails?id=<?php echo $category['id']; ?>" class="learn-more">
                                LEARN MORE <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize any necessary JavaScript here
        $(document).ready(function() {
            // Counter animation
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>
</body>
</html>