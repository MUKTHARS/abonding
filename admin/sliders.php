<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Check if user is logged in and has admin access
checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_slider'])) {
        // Handle slider addition
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $buttonText = $_POST['button_text'] ?? 'Read More';
        $buttonLink = $_POST['button_link'] ?? '#';
        $displayOrder = $_POST['display_order'] ?? 0;
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = SLIDER_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/sliders/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO sliders (image_path, title, description, button_text, button_link, display_order) VALUES (?, ?, ?, ?, ?, ?)",
            [$imagePath, $title, $description, $buttonText, $buttonLink, $displayOrder]
        );
        
        $_SESSION['message'] = 'Slider added successfully!';
        header('Location: sliders.php');
        exit;
    }
    
    // Handle other actions (update, delete, etc.)
}

// Get all sliders
$sliders = $db->fetchAll("SELECT * FROM sliders ORDER BY display_order");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sliders - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin-header.php'; ?>
    
    <div class="container mt-4">
        <h2>Manage Sliders</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add New Slider</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="image" class="form-label">Slider Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title (Optional)</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="button_text" name="button_text" value="Read More">
                        </div>
                        <div class="col-md-6">
                            <label for="button_link" class="form-label">Button Link</label>
                            <input type="text" class="form-control" id="button_link" name="button_link" value="#">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                    </div>
                    <button type="submit" name="add_slider" class="btn btn-primary">Add Slider</button>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Existing Sliders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Button</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sliders as $slider): ?>
                            <tr>
                                <td><img src="../<?php echo htmlspecialchars($slider['image_path']); ?>" style="max-width: 100px;"></td>
                                <td><?php echo htmlspecialchars($slider['description']); ?></td>
                                <td><?php echo htmlspecialchars($slider['button_text']); ?></td>
                                <td><?php echo htmlspecialchars($slider['display_order']); ?></td>
                                <td><?php echo $slider['is_active'] ? 'Active' : 'Inactive'; ?></td>
                                <td>
                                    <a href="edit-slider.php?id=<?php echo $slider['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete-slider.php?id=<?php echo $slider['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>