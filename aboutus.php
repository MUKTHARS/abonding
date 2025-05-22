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
    <title><?php echo htmlspecialchars($aboutContent['title']); ?></title>
    <!-- Include all your CSS and JS files from the original design -->
   <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/footer.css">
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