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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Range - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <!-- Include your CSS and JS files -->
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="product-range-section">
        <div class="container py-5">
            <div class="title-container mb-5">
                <h2 class="section-title">Our <span>Product Range</span></h2>
                <div class="underline"></div>
            </div>
            
            <?php foreach ($categories as $category): ?>
            <div class="category-section mb-5">
                <h3 class="category-title"><?php echo htmlspecialchars($category['name']); ?></h3>
                <div class="row">
                    <?php foreach ($category['products'] as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card product-card h-100">
                            <?php if ($product['image_path']): ?>
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?php echo htmlspecialchars($product['link'] ?? '#'); ?>" class="btn btn-success">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>