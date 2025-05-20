<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAdminAccess();

// Get counts for dashboard
$sliderCount = $db->fetchOne("SELECT COUNT(*) as count FROM sliders")['count'];
$productCount = $db->fetchOne("SELECT COUNT(*) as count FROM products")['count'];
$industryCount = $db->fetchOne("SELECT COUNT(*) as count FROM industries")['count'];
$awardCount = $db->fetchOne("SELECT COUNT(*) as count FROM awards")['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/admin-sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2 mb-4">Dashboard</h1>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Sliders</h5>
                                <h2><?php echo $sliderCount; ?></h2>
                                <a href="sliders.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Products</h5>
                                <h2><?php echo $productCount; ?></h2>
                                <a href="products.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Industries</h5>
                                <h2><?php echo $industryCount; ?></h2>
                                <a href="industries.php" class="text-white">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body">
                                <h5 class="card-title">Awards</h5>
                                <h2><?php echo $awardCount; ?></h2>
                                <a href="awards.php" class="text-dark">Manage <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="sliders.php?action=add" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-plus-lg"></i> Add Slider
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="products.php?action=add" class="btn btn-outline-success w-100">
                                    <i class="bi bi-plus-lg"></i> Add Product
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="industries.php?action=add" class="btn btn-outline-info w-100">
                                    <i class="bi bi-plus-lg"></i> Add Industry
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="awards.php?action=add" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-plus-lg"></i> Add Award
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>