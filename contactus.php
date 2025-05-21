<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($message)) $errors[] = 'Message is required';
    
    if (empty($errors)) {
        // Save to database (you would need a contacts table)
        $db->query(
            "INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)",
            [$name, $email, $phone, $subject, $message]
        );
        
        // Send email (configure your mail server)
        $to = 'info@abonding.com';
        $headers = "From: $email\r\nReply-To: $email";
        $emailSubject = "Contact Form Submission: $subject";
        $emailBody = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        
        mail($to, $emailSubject, $emailBody, $headers);
        
        $_SESSION['message'] = 'Thank you for your message! We will get back to you soon.';
        header('Location: contactus.php');
        exit;
    }
}

// Get site settings for contact info
$settings = $db->fetchOne("SELECT * FROM site_settings LIMIT 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - <?php echo htmlspecialchars($settings['site_name'] ?? 'Abonding'); ?></title>
    <!-- Include your CSS and JS files -->
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <section class="contact-section">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6">
                    <h2>Contact Us</h2>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Send Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h2>Our Information</h2>
                    <div class="contact-info">
                        <p><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($settings['contact_phone'] ?? '+91 94425 76397'); ?></p>
                        <p><i class="bi bi-whatsapp"></i> <?php echo htmlspecialchars($settings['contact_whatsapp'] ?? '+91 94425 76397'); ?></p>
                        <p><i class="bi bi-envelope"></i> info@abonding.com</p>
                        <p><i class="bi bi-geo-alt"></i> Company Address Here</p>
                    </div>
                    
                    <div class="map-container mt-4">
                        <!-- Embed your Google Map here -->
                        <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>