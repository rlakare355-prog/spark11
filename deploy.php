<?php
// SPARK Platform - Deployment and Testing Script

echo "SPARK Platform - Testing & Deployment Script\n";
echo "=========================================\n\n";

// Check required extensions
$requiredExtensions = ['pdo', 'curl', 'json', 'mbstring', 'gd'];
echo "Checking PHP Extensions...\n";
$missingExtensions = [];

foreach ($requiredExtensions as $extension) {
    if (!extension_loaded($extension)) {
        $missingExtensions[] = $extension;
    }
}

if (empty($missingExtensions)) {
    echo "✓ All required extensions are loaded\n";
} else {
    echo "✗ Missing extensions: " . implode(', ', $missingExtensions) . "\n";
    echo "Please install the missing PHP extensions before continuing.\n";
    exit(1);
}

// Check file permissions and structure
echo "\nChecking File Structure...\n";
$requiredFiles = [
    'includes/config.php',
    'includes/database.php',
    'includes/auth.php',
    'includes/MailjetService.php',
    'database/schema.sql',
    'student/index.php',
    'student/dashboard.php',
    'admin/login.php',
    'admin/index.php'
];

foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "✓ $file\n";
    } else {
        echo "✗ $file - MISSING\n";
    }
}

// Test database connection (if config allows)
echo "\nTesting Database Connection...\n";
try {
    require_once 'includes/config.php';
    require_once 'includes/database.php';

    $pdo = getPDO();
    if ($pdo) {
        echo "✓ Database connection successful\n";

        // Test basic query
        $test = dbFetch("SELECT 1 as test");
        if ($test && $test['test'] == 1) {
            echo "✓ Database query execution successful\n";
        } else {
            echo "✗ Database query execution failed\n";
        }
    } else {
        echo "✗ Database connection failed\n";
    }
} catch (Exception $e) {
    echo "✗ Database test failed: " . $e->getMessage() . "\n";
}

// Check .htaccess requirements
echo "\nChecking .htaccess Requirements...\n";
if (file_exists('.htaccess')) {
    echo "✓ .htaccess exists\n";
} else {
    echo "! .htaccess not found - creating basic .htaccess\n";
    $htaccessContent = "
# SPARK Platform - Apache Configuration
RewriteEngine On

# Security headers
Header always set X-Content-Type-Options: nosniff
Header always set X-Frame-Options: DENY
Header always set X-XSS-Protection: 1; mode=block
Header always set Referrer-Policy: strict-origin-when-cross-origin

# Hide PHP errors in production (comment out for development)
# php_flag display_errors off

# URL rewriting for clean URLs
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule ^(.*)$ index.php [QSA,L]

# Set default charset
AddDefaultCharset UTF-8

# Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/json
</IfModule>
";
    file_put_contents('.htaccess', $htaccessContent);
    echo "✓ Basic .htaccess created\n";
}

// Security checks
echo "\nPerforming Security Checks...\n";

// Check if sensitive files are accessible
$sensitiveFiles = [
    'includes/config.php',
    'database/schema.sql',
    'admin/login.php',
    'api/payment.php'
];

echo "Checking sensitive file access...\n";
foreach ($sensitiveFiles as $file) {
    if (file_exists($file)) {
        // Check if file is in web-accessible directories
        $inPublicDir = strpos($file, 'admin/') !== false || strpos($file, 'api/') !== false || strpos($file, 'student/') !== false;

        if ($inPublicDir) {
            echo "⚠ $file is in public directory - ensure proper access controls\n";
        }
    }
}

// Performance optimizations
echo "\nChecking Performance Optimizations...\n";

// Check if opcache is available
if (function_exists('opcache_get_status')) {
    echo "✓ OPcache is available\n";
} else {
    echo "! OPcache not available - consider installing for better performance\n";
}

// Check memory limit
$memoryLimit = ini_get('memory_limit');
echo "Memory Limit: $memoryLimit\n";
if ($memoryLimit && $memoryLimit < '256M') {
    echo "⚠ Memory limit might be low for this application\n";
}

// File upload checks
$uploadMaxFilesize = ini_get('upload_max_filesize');
$postMaxSize = ini_get('post_max_size');
echo "Max Upload Size: $uploadMaxFilesize\n";
echo "Max POST Size: $postMaxSize\n";

// Recommendations
echo "\nRecommendations:\n";
echo "1. Set up Apache/Nginx with proper SSL certificate\n";
echo "2. Configure production database credentials\n";
echo "3. Set up proper backup schedule\n";
echo "4. Configure Mailjet API keys in admin panel\n";
echo "5. Set up proper error logging\n";
echo "6. Consider implementing Redis for session storage\n";
echo "7. Set up CDN for static assets\n";

// Final summary
echo "\n" . str_repeat("=", 50) . "\n";
echo "SPARK Platform Deployment Summary\n";
echo "===============================\n\n";

echo "Next Steps:\n";
echo "1. Upload files to web server\n";
echo "2. Import database schema\n";
echo "3. Update configuration settings\n";
echo "4. Test all functionality\n";
echo "5. Set up monitoring and backups\n";

echo "\nDeployment files are ready! 🚀\n";

// Create installation checklist
$checklist = "# SPARK Platform Installation Checklist\n\n";
$checklist .= "## Pre-Installation\n";
$checklist .= "- [ ] Web server (Apache/Nginx) configured\n";
$checklist .= "- [ ] PHP 8.0+ installed\n";
$checklist .= "- [ ] MySQL/MariaDB 5.7+ installed\n";
$checklist .= "- [ ] Required PHP extensions enabled\n";
$checklist .= "- [ ] SSL certificate configured\n\n";

$checklist .= "## Installation\n";
$checklist .= "- [ ] Files uploaded to web server\n";
$checklist .= "- [ ] Database schema imported\n";
$checklist .= "- [ ] File permissions set correctly\n";
$checklist .= "- [ ] .htaccess configured\n";
$checklist .= "- [ ] Configuration settings updated\n\n";

$checklist .= "## Post-Installation\n";
$checklist .= "- [ ] Test user registration\n";
$checklist .= "- [ ] Test email verification (Mailjet configured)\n";
$checklist .= "- [ ] Test event registration\n";
$checklist .= "- [ ] Test payment integration (Razorpay)\n";
$checklist .= "- [ ] Test QR attendance system\n";
$checklist .= "- [ ] Test admin panel functionality\n";
$checklist .= "- [ ] Test email notifications\n";
$checklist .= "- [ ] Test responsive design\n";
$checklist .= "- [ ] Set up monitoring\n";
$checklist .= "- [ ] Configure backups\n";
$checklist .= "- [ ] Performance test\n";
$checklist .= "- [ ] Security audit\n\n";

$checklist .= "## Go Live\n";
$checklist .= "- [ ] DNS configured\n";
$checklist .= "- [ ] Domain pointing to correct location\n";
$checklist .= "- [ ] SSL certificate active\n";
$checklist .= "- [ ] Production database configured\n";
$checklist .= "- [ ] API keys configured\n";
$checklist .= "- [ ] Error reporting set to minimum\n";
$checklist .= "- [ ] Cache enabled\n";
$checklist .= "- [ ] Monitoring active\n";
$checklist .= "- [ ] Backup schedule configured\n\n";

file_put_contents('INSTALLATION_CHECKLIST.md', $checklist);

echo "✓ Installation checklist created: INSTALLATION_CHECKLIST.md\n";
echo "\n🎉 SPARK Platform is ready for deployment! 🎉\n";
?>