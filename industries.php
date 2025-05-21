<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get all active industries
$industries = $db->fetchAll("SELECT * FROM industries WHERE is_active = 1 ORDER BY name");

// Get site settings for industries description
$settings = $db->fetchOne("SELECT industries_description FROM site_settings LIMIT 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industries We Serve - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
    <link rel="stylesheet" href="assets/css/style.css">
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