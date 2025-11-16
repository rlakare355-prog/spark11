# XAMPP Deployment Guide - SPARK Platform

## ✅ ALL ERRORS FIXED

All errors have been fixed in the Replit code. You need to **copy the updated files** to your XAMPP installation.

### Fixed Issues:
1. ✅ **requireAdminLogin() Error** - Changed to `requireAdmin()` in all 12 admin pages
2. ✅ **Loading SPARK... stuck** - Added required includes to templates/header.php
3. ✅ **Missing functions** - Added all helper functions to includes/functions.php
4. ✅ **Public access** - Public pages now work without login
5. ✅ **No PHP syntax errors** - All files validated

---

## 🚀 DEPLOYMENT STEPS FOR XAMPP

### Step 1: Copy Files to XAMPP
Copy ALL files from this Replit project to your XAMPP directory:

```
FROM: All files in this Replit project
TO: C:\xampp\htdocs\spark\
```

**Important:** Make sure to overwrite all existing files!

### Step 2: Database Setup

1. **Start MySQL** in XAMPP Control Panel
2. **Open phpMyAdmin**: http://localhost/phpmyadmin/
3. **Create Database**:
   - Click "New" in left sidebar
   - Database name: `spark_platform`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. **Import Schema**:
   - Select `spark_platform` database
   - Click "Import" tab
   - Choose file: `C:\xampp\htdocs\spark\database\schema.sql`
   - Click "Go"

### Step 3: Configure Database Connection

Edit `C:\xampp\htdocs\spark\includes\config.php`:

```php
// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'spark_platform');
define('DB_USER', 'root');
define('DB_PASS', '');  // Keep empty for default XAMPP

// Site settings
define('SITE_URL', 'http://localhost/spark');
```

### Step 4: Set Permissions

Make sure these folders are writable:
- `C:\xampp\htdocs\spark\assets\images\`
- `C:\xampp\htdocs\spark\uploads\`

### Step 5: Install Composer Dependencies

Open Command Prompt in `C:\xampp\htdocs\spark\` and run:

```bash
composer install
```

If you don't have Composer, download it from: https://getcomposer.org/download/

### Step 6: Start Apache & MySQL

In XAMPP Control Panel:
1. Click "Start" for Apache
2. Click "Start" for MySQL

### Step 7: Clear Browser Cache

Press **Ctrl + Shift + Delete** or **Ctrl + F5** to clear cache

### Step 8: Access the Application

- **Home Page**: http://localhost/spark/
- **Student Portal**: http://localhost/spark/student/
- **Admin Portal**: http://localhost/spark/admin/

---

## 📋 PUBLIC PAGES (No Login Required)

These pages are accessible without logging in:
- ✅ Home: `http://localhost/spark/student/`
- ✅ Events: `http://localhost/spark/student/events.php`
- ✅ Research: `http://localhost/spark/student/research.php`
- ✅ Opportunities: `http://localhost/spark/student/opportunities.php`
- ✅ Team: `http://localhost/spark/student/team.php`
- ✅ Gallery: `http://localhost/spark/student/gallery.php`
- ✅ Contact: `http://localhost/spark/student/contact.php`

## 🔒 LOGIN-PROTECTED PAGES

These pages require login:
- Dashboard: `http://localhost/spark/student/dashboard.php`
- Profile: `http://localhost/spark/student/profile.php`
- Attendance: `http://localhost/spark/student/attendance.php`
- Certificates: `http://localhost/spark/student/certificates.php`
- Calendar: `http://localhost/spark/student/calendar.php`

## 🔐 ADMIN PAGES (All Fixed)

All admin pages now use the correct `requireAdmin()` function:
- Homepage Management: `http://localhost/spark/admin/homepage.php`
- Attendance: `http://localhost/spark/admin/attendance.php`
- Certificates: `http://localhost/spark/admin/certificates.php`
- Contact: `http://localhost/spark/admin/contact.php`
- Events: `http://localhost/spark/admin/events.php`
- Gallery: `http://localhost/spark/admin/gallery.php`
- Logs: `http://localhost/spark/admin/logs.php`
- Opportunities: `http://localhost/spark/admin/opportunities.php`
- Payments: `http://localhost/spark/admin/payments.php`
- Research: `http://localhost/spark/admin/research.php`
- Roles: `http://localhost/spark/admin/roles.php`
- Team: `http://localhost/spark/admin/team.php`

---

## ⚠️ TROUBLESHOOTING

### Error: "requireAdminLogin() not found"
**Solution:** You're using old files. Copy ALL files from Replit to XAMPP again.

### Error: "Loading SPARK..." stuck
**Solution:** 
1. Clear browser cache (Ctrl + F5)
2. Make sure you copied `templates/header.php` with the latest changes

### Error: "Database connection failed"
**Solution:**
1. Check MySQL is running in XAMPP
2. Verify database name in `includes/config.php` matches your database
3. Make sure database credentials are correct

### Research page shows blank
**Solution:**
1. Make sure you imported `database/schema.sql`
2. Check if `research_projects` table exists in phpMyAdmin
3. Add some test data to the table

### Missing functions error
**Solution:** Make sure `includes/functions.php` has all the latest updates

---

## 📝 FILES WITH FIXES

### Admin Files Fixed (12 files):
- admin/homepage.php
- admin/attendance.php
- admin/certificates.php
- admin/contact.php
- admin/events.php
- admin/gallery.php
- admin/logs.php
- admin/opportunities.php
- admin/payments.php
- admin/research.php
- admin/roles.php
- admin/team.php

### Core Files Fixed (3 files):
- includes/functions.php (added missing functions)
- templates/header.php (added required includes)
- index.php (improved redirect logic)

---

## ✨ NEW FEATURES ADDED

### Helper Functions Added to `includes/functions.php`:
- `formatTime()` - Format time for display
- `generateQRCodeId()` - Generate unique QR code IDs
- `generateCertificateNumber()` - Generate certificate numbers
- `executeInsert()` - Execute INSERT queries
- `generateThumbnail()` - Generate image thumbnails

---

## 🎯 VERIFICATION CHECKLIST

After deployment, verify:
- [ ] Apache and MySQL are running in XAMPP
- [ ] Database `spark_platform` exists
- [ ] All tables are created (from schema.sql)
- [ ] Home page loads without errors
- [ ] Events page shows content (or empty state)
- [ ] Admin login works
- [ ] No "requireAdminLogin" errors
- [ ] No "Loading SPARK..." stuck on any page

---

## 📞 STILL GETTING ERRORS?

Check the Apache error log:
- Location: `C:\xampp\apache\logs\error.log`
- Open it with Notepad and check the latest errors

Check the PHP error log:
- Location: `C:\xampp\php\logs\php_error_log`

---

## ✅ SUMMARY

All code errors have been fixed in this Replit environment. The error you're seeing on XAMPP is because you're using old files. 

**Action Required:** 
1. Copy ALL files from Replit to `C:\xampp\htdocs\spark\`
2. Make sure to overwrite existing files
3. Clear browser cache
4. Refresh the page

The application will work perfectly after copying the updated files!
