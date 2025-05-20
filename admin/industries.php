<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAdminAccess();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_industry'])) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = INDUSTRY_UPLOAD_PATH;
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'uploads/industries/' . $fileName;
            }
        }
        
        // Insert into database
        $db->query(
            "INSERT INTO industries (name, image_path, description) VALUES (?, ?, ?)",
            [$name, $imagePath, $description]
        );
        
        $_SESSION['message'] = 'Industry added successfully!';
        header('Location: industries.php');
        exit;
    }
}

// Get all industries
$industries = $db->fetchAll("SELECT * FROM industries ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Industries - Admin Panel</title>
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
                    <h1 class="h2">Manage Industries</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="industries.php?action=add" class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Add Industry
                        </a>
                    </div>
                </div>
                
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                <?php endif; ?>
                
                <?php if (isset($_GET['action']) && $_GET['action'] === 'add'): ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Add New Industry</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Industry Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Industry Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                                <button type="submit" name="add_industry" class="btn btn-primary">Add Industry</button>
                                <a href="industries.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5>Existing Industries</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($industries as $industry): ?>
                                    <tr>
                                        <td>
                                            <?php if ($industry['image_path']): ?>
                                                <img src="../<?php echo htmlspecialchars($industry['image_path']); ?>" style="max-width: 80px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($industry['name']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($industry['description'], 0, 50)); ?>...</td>
                                        <td>
                                            <a href="edit-industry.php?id=<?php echo $industry['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="delete-industry.php?id=<?php echo $industry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>