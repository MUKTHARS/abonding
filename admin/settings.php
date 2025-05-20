<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAdminAccess();

// Get current settings
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteName = $_POST['site_name'] ?? '';
    $copyright = $_POST['copyright'] ?? '';
    $whatsapp = $_POST['contact_whatsapp'] ?? '';
    $phone = $_POST['contact_phone'] ?? '';
    $industriesDesc = $_POST['industries_description'] ?? '';
    
    // Handle logo upload
    $logoPath = $settings['logo_path'] ?? '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = UPLOAD_PATH;
        $fileName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            $logoPath = 'uploads/' . $fileName;
            
            // Delete old logo if it exists
            if (!empty($settings['logo_path']) {
                @unlink('../' . $settings['logo_path']);
            }
        }
    }
    
    if ($settings) {
        // Update existing settings
        $db->query(
            "UPDATE site_settings SET 
                site_name = ?, 
                logo_path = ?, 
                footer_copyright = ?, 
                contact_whatsapp = ?, 
                contact_phone = ?,
                industries_description = ? 
            WHERE id = ?",
            [$siteName, $logoPath, $copyright, $whatsapp, $phone, $industriesDesc, $settings['id']]
        );
    } else {
        // Insert new settings
        $db->query(
            "INSERT INTO site_settings 
                (site_name, logo_path, footer_copyright, contact_whatsapp, contact_phone, industries_description) 
            VALUES (?, ?, ?, ?, ?, ?)",
            [$siteName, $logoPath, $copyright, $whatsapp, $phone, $industriesDesc]
        );
    }
    
    $_SESSION['message'] = 'Settings updated successfully!';
    header('Location: settings.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/admin-sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Site Settings</h1>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site