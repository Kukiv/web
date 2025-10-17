<?php
// Simple PHP Website - Contact Page
$page_title = "Contact Us - My PHP Site";
$current_page = "contact";

// Initialize variables
$name = $email = $message = '';
$success_message = '';
$error_message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // In a real application, you would send an email here
        // For this demo, we'll just save to a file and show success message
        
        $contact_data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
        ];
        
        // Save to file (in a real app, you'd use a database)
        $log_entry = json_encode($contact_data) . "\n";
        file_put_contents('contact_submissions.txt', $log_entry, FILE_APPEND | LOCK_EX);
        
        $success_message = 'Thank you for your message! We will get back to you soon.';
        
        // Clear form data
        $name = $email = $message = '';
    } else {
        $error_message = implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-brand">
                <h1>My PHP Site</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="<?php echo $current_page == 'home' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="<?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="contact.php" class="<?php echo $current_page == 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h2>Contact Us</h2>
                <p>Get in touch with us! We'd love to hear from you.</p>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <div style="max-width: 600px; margin: 0 auto;">
                    <?php if ($success_message): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-error">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" required><?php echo htmlspecialchars($message); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="info">
            <div class="container">
                <h3>Contact Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Email:</strong> contact@myphpsite.com
                    </div>
                    <div class="info-item">
                        <strong>Phone:</strong> (555) 123-4567
                    </div>
                    <div class="info-item">
                        <strong>Address:</strong> 123 Web Street, Digital City, DC 12345
                    </div>
                    <div class="info-item">
                        <strong>Business Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> My PHP Site. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
