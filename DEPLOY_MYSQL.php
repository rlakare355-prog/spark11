<?php
// SPARK Platform - MySQL Deployment Script

echo "SPARK Platform - MySQL Deployment Script\n";
echo "======================================\n\n";

// MySQL-specific server requirements check
echo "Checking MySQL Server Requirements...\n";

$requiredExtensions = ['pdo_mysql', 'curl', 'json', 'mbstring', 'gd', 'openssl'];
$missingExtensions = [];

foreach ($requiredExtensions as $extension) {
    if (!extension_loaded($extension)) {
        $missingExtensions[] = $extension;
    }
}

if (empty($missingExtensions)) {
    echo "✓ All required PHP extensions are loaded\n";
} else {
    echo "✗ Missing extensions: " . implode(', ', $missingExtensions) . "\n";
    exit(1);
}

// Test MySQL connectivity
echo "\nTesting MySQL Connection...\n";
try {
    require_once 'includes/config.php';
    require_once 'includes/database.php';

    $testResult = testConnection();
    if ($testResult['connected']) {
        echo "✓ MySQL connection successful\n";
        echo "  MySQL Version: " . $testResult['mysql_version'] . "\n";
    } else {
        echo "✗ MySQL connection failed\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "✗ Database test failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Verify MySQL configuration
echo "\nVerifying MySQL Configuration...\n";
try {
    $pdo = getPDO();

    // Check charset and collation
    $charsetCheck = $pdo->query("SELECT DEFAULT_CHARACTER_SET_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = DATABASE()")->fetch();

    if ($charsetCheck && $charsetCheck[0] === 'utf8mb4') {
        echo "✓ Database charset is utf8mb4\n";
    }

    // Check SQL mode
    $sqlModeCheck = $pdo->query("SELECT @@sql_mode")->fetchColumn();
    if (strpos($sqlModeCheck, 'STRICT_TRANS_TABLES') !== false) {
        echo "✓ Strict SQL mode is enabled\n";
    }

} catch (Exception $e) {
    echo "✗ Configuration check failed: " . $e->getMessage() . "\n";
}

// Test MySQL-specific features
echo "\nTesting MySQL-Specific Features...\n";
try {
    $pdo = getPDO();

    // Test JSON support (MySQL 5.7+)
    try {
        $jsonTest = $pdo->query("SELECT JSON_ARRAY(1, 2, 3) as json_test")->fetch();
        if ($jsonTest) {
            echo "✓ JSON functions available\n";
        }
    } catch (Exception $e) {
        echo "⚠ JSON functions not available (MySQL < 5.7)\n";
    }

    // Test InnoDB engine
    $engineTest = $pdo->query("SHOW ENGINES")->fetchAll(PDO::FETCH_ASSOC);
    $innodbAvailable = false;
    foreach ($engineTest as $engine) {
        if ($engine['Engine'] === 'InnoDB' && $engine['Support'] !== 'NO') {
            $innodbAvailable = true;
            break;
        }
    }

    if ($innodbAvailable) {
        echo "✓ InnoDB engine is available\n";
    }

} catch (Exception $e) {
    echo "✗ Feature test failed: " . $e->getMessage() . "\n";
}

echo "\n🎉 SPARK Platform is ready for MySQL deployment! 🚀\n";
echo "For support: SETUP_GUIDE.md\n\n";
?>