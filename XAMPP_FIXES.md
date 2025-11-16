# XAMPP Setup Fixes for SPARK Platform

This document contains all the fixes needed to run the SPARK platform on XAMPP (PHP + MySQL).

## Issues Found and Fixes

### 1. Missing `getCurrentUser()` Function Error

**Problem:** Pages calling `getCurrentUser()` without including `auth.php`

**Files affected:**
- `student/events.php` (line 16)
- `student/certificates.php` (line 17)
- `admin/index.php` (line 11)
- And other similar files

**Fix:** Add this line near the top of these files (after config.php include):

```php
if (!function_exists('getCurrentUser')) {
    require_once __DIR__ . '/../includes/auth.php';
}
```

---

### 2. Missing `is_active` Column in Database Tables

**Problem:** SQL queries reference `is_active` column that doesn't exist in database tables

**Tables affected:**
- `research_projects` table
- `opportunities` table

**Fix:** Run these SQL commands in phpMyAdmin or MySQL command line:

```sql
-- Add is_active column to research_projects table
ALTER TABLE research_projects 
ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER status,
ADD INDEX idx_is_active (is_active);

-- Add is_featured column to research_projects table (used in queries)
ALTER TABLE research_projects 
ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER is_active,
ADD INDEX idx_is_featured (is_featured);

-- Add end_date column to research_projects table (used in queries)
ALTER TABLE research_projects 
ADD COLUMN end_date DATE DEFAULT NULL AFTER updated_at,
ADD INDEX idx_end_date (end_date);

-- Add is_active column to opportunities table
ALTER TABLE opportunities 
ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER is_featured,
ADD INDEX idx_is_active_opp (is_active);

-- Add uploaded_by column to opportunities (if it doesn't exist, replacing created_by)
-- The schema shows created_by but the code uses uploaded_by
ALTER TABLE opportunities 
CHANGE COLUMN created_by uploaded_by INT UNSIGNED DEFAULT NULL;
```

---

### 3. Deprecated `trim()` Warning (PHP 8.1+)

**Problem:** `trim()` function receiving `null` value in `includes/config.php` line 101

**Fix:** Update the `sanitize()` function in `includes/config.php`:

**BEFORE:**
```php
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
```

**AFTER:**
```php
function sanitize($input) {
    return htmlspecialchars(trim($input ?? ''), ENT_QUOTES, 'UTF-8');
}
```

---

### 4. Pages Stuck on "Loading SPARK..."

**Problem:** JavaScript files not loading properly or AJAX requests failing

**Possible causes and fixes:**

#### A. Check if database is properly set up
1. Open phpMyAdmin
2. Check if database `spark_platform` exists
3. Verify all tables are created (run `database/schema.sql` if needed)

#### B. Update database connection in `includes/config.php`
Make sure these match your XAMPP setup:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'spark_platform');
define('DB_USER', 'root');
define('DB_PASS', ''); // Empty for XAMPP default
```

#### C. Update SITE_URL in `includes/config.php`
Change to match your XAMPP installation:
```php
define('SITE_URL', 'http://localhost/spark');
```

If your project is in a different folder, adjust accordingly (e.g., `http://localhost:8080/spark`).

#### D. Check JavaScript console for errors
1. Open the page in browser (Chrome/Firefox)
2. Press F12 to open Developer Tools
3. Go to Console tab
4. Look for any JavaScript errors
5. Look for failed AJAX requests in the Network tab

---

### 5. Missing Database Columns Summary

Run this complete SQL script to add all missing columns:

```sql
USE spark_platform;

-- Fix research_projects table
ALTER TABLE research_projects 
ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1 AFTER status,
ADD COLUMN IF NOT EXISTS is_featured TINYINT(1) DEFAULT 0 AFTER is_active,
ADD COLUMN IF NOT EXISTS end_date DATE DEFAULT NULL AFTER updated_at;

-- Add indexes
ALTER TABLE research_projects 
ADD INDEX IF NOT EXISTS idx_is_active (is_active),
ADD INDEX IF NOT EXISTS idx_is_featured (is_featured),
ADD INDEX IF NOT EXISTS idx_end_date (end_date);

-- Fix opportunities table
ALTER TABLE opportunities 
ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1 AFTER is_featured;

-- Add index
ALTER TABLE opportunities 
ADD INDEX IF NOT EXISTS idx_is_active_opp (is_active);

-- Update existing records to be active
UPDATE research_projects SET is_active = 1 WHERE is_active IS NULL;
UPDATE opportunities SET is_active = 1 WHERE is_active IS NULL;
```

---

## Complete Setup Steps for XAMPP

1. **Start XAMPP Services**
   - Start Apache
   - Start MySQL

2. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create new database named `spark_platform`
   - Import `database/schema.sql`
   - Run the SQL fixes above

3. **Configure Application**
   - Edit `includes/config.php`
   - Update `SITE_URL` to match your setup
   - Verify database credentials

4. **Apply Code Fixes**
   - Fix `sanitize()` function in `includes/config.php`
   - Add `auth.php` includes to affected files

5. **Test the Application**
   - Open http://localhost/spark in your browser
   - Check for any errors in browser console (F12)
   - Check PHP errors in XAMPP Control Panel logs

---

## Quick Test Checklist

- [ ] Can access homepage (http://localhost/spark)
- [ ] Student registration works
- [ ] Student login works
- [ ] Dashboard loads without errors
- [ ] Events page displays
- [ ] Research page displays
- [ ] Opportunities page displays
- [ ] No "Call to undefined function" errors
- [ ] No "Unknown column" SQL errors
- [ ] No "Loading SPARK..." stuck pages

---

## Common XAMPP Issues

### Port Conflicts
If Apache won't start, port 80 might be in use:
- Change Apache port in XAMPP config
- Update SITE_URL accordingly

### PHP Version
SPARK requires PHP 7.4 or higher:
- Check PHP version in XAMPP Control Panel
- Update if needed

### File Permissions
On Windows, usually not an issue, but on Linux/Mac:
```bash
chmod -R 755 /path/to/spark
chmod -R 777 /path/to/spark/assets
```

---

## Need More Help?

If you still see errors after applying these fixes:
1. Check the exact error message
2. Look at PHP error logs in XAMPP (xampp/apache/logs/error.log)
3. Check browser console for JavaScript errors
4. Verify database structure matches the schema

---

**Last Updated:** 2025-11-15
**Compatible with:** XAMPP 8.x, PHP 7.4+, MySQL 5.7+
