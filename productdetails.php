<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get product category ID from URL
$categoryId = $_GET['id'] ?? 0;

// Get product category details
$category = $db->fetchOne("SELECT * FROM product_categories WHERE id = ?", [$categoryId]);

if (!$category) {
    header('Location: productrange.php');
    exit;
}

// Get products in this category
$products = $db->fetchAll("SELECT * FROM products WHERE category_id = ? AND is_active = 1 ORDER BY name", [$categoryId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['name']); ?> - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
    <style>
        .product-detail-section {
            padding: 60px 0;
        }
        
        .product-header {
            margin-bottom: 40px;
        }
        
        .product-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-title {
            font-size: 2.2rem;
            color: #019626;
            margin-bottom: 20px;
        }
        
        .product-manufacturer {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        .product-description {
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .section-title {
            font-size: 1.5rem;
            color: #019626;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        
        .product-features {
            margin-bottom: 30px;
        }
        
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #019626;
            margin-bottom: 20px;
        }
        
        .back-link i {
            margin-right: 5px;
        }
    </style>
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
    
    <section class="product-detail-section">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>/productrange.php" class="back-link">
                <i class="bi bi-arrow-left"></i> Back to Product Range
            </a>
            
            <div class="product-header">
                <div class="row">
                    <div class="col-md-5">
                        <?php if ($category['image_path']): ?>
                        <img src="<?php echo BASE_URL . '/' . htmlspecialchars($category['image_path']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>" class="product-image">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <h1 class="product-title"><?php echo htmlspecialchars($category['name']); ?></h1>
                        <?php if (!empty($category['manufacturer'])): ?>
                        <p class="product-manufacturer">Manufacturer: <?php echo htmlspecialchars($category['manufacturer']); ?></p>
                        <?php endif; ?>
                        <div class="product-description">
                            <?php echo nl2br(htmlspecialchars($category['description'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($category['applications'])): ?>
            <div class="product-features">
                <h3 class="section-title">Applications</h3>
                <div class="row">
                    <div class="col-12">
                        <?php echo nl2br(htmlspecialchars($category['applications'])); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($category['benefits'])): ?>
            <div class="product-features">
                <h3 class="section-title">Benefits</h3>
                <div class="row">
                    <div class="col-12">
                        <?php echo nl2br(htmlspecialchars($category['benefits'])); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($products)): ?>
            <div class="related-products">
                <h3 class="section-title">Products in this Category</h3>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <?php if ($product['image_path']): ?>
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                            <a href="#" class="btn btn-success">View Details</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>