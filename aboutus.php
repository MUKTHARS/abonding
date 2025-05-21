<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get about us content from database (you would need an about_us table)
$aboutContent = $db->fetchOne("SELECT * FROM about_us LIMIT 1");

// If no content exists, use default values
if (!$aboutContent) {
    $aboutContent = [
        'title' => 'About Abonding',
        'company_description' => 'We are a leading provider of quality solutions for various industries...',
        'vision' => 'To be the most trusted partner in our industry',
        'mission' => 'To deliver innovative solutions with exceptional service',
        'process' => 'Our rigorous process ensures quality at every step',
        'strengths' => 'Experienced team, quality products, customer focus'
    ];
}

// Get team members (you would need a team_members table)
$teamMembers = $db->fetchAll("SELECT * FROM team_members WHERE is_active = 1 ORDER BY display_order");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($aboutContent['title']); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="about-hero">
        <div class="container">
            <h1><?php echo htmlspecialchars($aboutContent['title']); ?></h1>
        </div>
    </section>

    <section class="about-content">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Our Company</h2>
                    <p><?php echo htmlspecialchars($aboutContent['company_description']); ?></p>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo BASE_URL; ?>/assets/img/about-company.jpg" alt="Our Company" class="img-fluid rounded">
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card vision-card">
                        <div class="card-body">
                            <h3><i class="bi bi-eye"></i> Our Vision</h3>
                            <p><?php echo htmlspecialchars($aboutContent['vision']); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mission-card">
                        <div class="card-body">
                            <h3><i class="bi bi-bullseye"></i> Our Mission</h3>
                            <p><?php echo htmlspecialchars($aboutContent['mission']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Process</h2>
                    <p><?php echo htmlspecialchars($aboutContent['process']); ?></p>
                </div>
            </div>
            
            <?php if (!empty($teamMembers)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Team</h2>
                    <div class="team-grid">
                        <?php foreach ($teamMembers as $member): ?>
                        <div class="team-member">
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($member['image_path']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                            <h4><?php echo htmlspecialchars($member['name']); ?></h4>
                            <p class="position"><?php echo htmlspecialchars($member['position']); ?></p>
                            <div class="social-links">
                                <?php if ($member['linkedin']): ?>
                                <a href="<?php echo htmlspecialchars($member['linkedin']); ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row mt-5">
                <div class="col-12">
                    <h2>Our Strengths</h2>
                    <ul class="strengths-list">
                        <?php 
                        $strengths = explode(',', $aboutContent['strengths']);
                        foreach ($strengths as $strength): 
                        ?>
                        <li><?php echo htmlspecialchars(trim($strength)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Include all your JS files -->
    <script src="assets/js/main.js"></script>
</body>
</html>