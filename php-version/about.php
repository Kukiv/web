<?php
// Simple PHP Website - About Page
$page_title = "About Us - My PHP Site";
$current_page = "about";
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
                <h2>About Our PHP Website</h2>
                <p>Learn more about this simple PHP website and its features.</p>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h3>What We Offer</h3>
                <div class="feature-grid">
                    <div class="feature-card">
                        <h4>PHP Development</h4>
                        <p>This website demonstrates basic PHP concepts including dynamic content, form processing, and server-side scripting.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Modern Design</h4>
                        <p>Clean, responsive design that works perfectly on desktop, tablet, and mobile devices.</p>
                    </div>
                    <div class="feature-card">
                        <h4>User-Friendly</h4>
                        <p>Intuitive navigation and user experience designed with simplicity in mind.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="info">
            <div class="container">
                <h3>Technical Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Language:</strong> PHP <?php echo phpversion(); ?>
                    </div>
                    <div class="info-item">
                        <strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/Nginx'; ?>
                    </div>
                    <div class="info-item">
                        <strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?>
                    </div>
                    <div class="info-item">
                        <strong>Current Time:</strong> <?php echo date('l, F j, Y \a\t g:i A'); ?>
                    </div>
                    <div class="info-item">
                        <strong>Timezone:</strong> <?php echo date_default_timezone_get(); ?>
                    </div>
                    <div class="info-item">
                        <strong>Memory Limit:</strong> <?php echo ini_get('memory_limit'); ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h3>PHP Features Demonstrated</h3>
                <div class="feature-grid">
                    <div class="feature-card">
                        <h4>Dynamic Content</h4>
                        <p>Server-side rendering with PHP variables and functions.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Form Processing</h4>
                        <p>Contact form with validation and email sending capabilities.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Session Management</h4>
                        <p>Basic session handling for user interactions.</p>
                    </div>
                    <div class="feature-card">
                        <h4>File Operations</h4>
                        <p>Reading and writing files, configuration management.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Error Handling</h4>
                        <p>Proper error handling and user feedback.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Security</h4>
                        <p>Input validation, XSS protection, and secure coding practices.</p>
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
