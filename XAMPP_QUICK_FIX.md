# Quick Fix Guide for XAMPP Setup

## ✅ Code Fixes Applied

The following code fixes have been applied to your files:

### 1. Fixed `sanitize()` function (PHP 8.1+ compatibility)
- **File:** `includes/config.php`
- **Fix:** Changed `trim($input)` to `trim($input ?? '')` to prevent null warnings

### 2. Added missing `auth.php` includes
- **File:** `student/events.php` - Added auth.php include
- **File:** `student/certificates.php` - Added auth.php include  
- **File:** `admin/index.php` - Added auth.php include

These fixes resolve the "Call to undefined function getCurrentUser()" errors.

---

## 🗄️ Database Fixes Required

**Run the SQL script:** `database_fixes.sql` in phpMyAdmin

This will add the missing columns:
- `research_projects.is_active`
- `research_projects.is_featured`
- `research_projects.end_date`
- `opportunities.is_active`

### How to run the SQL file:

1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Click on `spark_platform` database
3. Click "SQL" tab
4. Click "Choose File" and select `database_fixes.sql`
5. Click "Go"

**OR** Copy and paste the SQL from `database_fixes.sql` into the SQL tab

---

## 🔧 Remaining Issues to Check

### If pages still show "Loading SPARK..."

1. **Check if database is imported:**
   - Open phpMyAdmin
   - Verify `spark_platform` database exists
   - Verify tables are created
   - If not, import `database/schema.sql`

2. **Check browser console for errors:**
   - Open the page in Chrome/Firefox
   - Press F12 to open Developer Tools
   - Go to Console tab
   - Look for JavaScript errors
   - Check Network tab for failed requests

3. **Verify SITE_URL in config:**
   - Open `includes/config.php`
   - Make sure `SITE_URL` matches your setup:
     ```php
     define('SITE_URL', 'http://localhost/spark');
     ```
   - If your folder name is different, update accordingly

4. **Check Apache/PHP errors:**
   - Open XAMPP Control Panel
   - Click "Logs" button for Apache
   - Look for PHP errors
   - Common location: `xampp/apache/logs/error.log`

---

## 🎯 Testing Steps

After applying all fixes:

1. ✅ Start XAMPP (Apache + MySQL)
2. ✅ Run `database_fixes.sql` in phpMyAdmin
3. ✅ Visit http://localhost/spark
4. ✅ Test student registration
5. ✅ Test student login
6. ✅ Test these pages:
   - Dashboard - http://localhost/spark/student/dashboard.php
   - Events - http://localhost/spark/student/events.php
   - Research - http://localhost/spark/student/research.php
   - Opportunities - http://localhost/spark/student/opportunities.php
   - Certificates - http://localhost/spark/student/certificates.php

---

## 📝 Summary of All Fixes

| Issue | Fixed | How |
|-------|-------|-----|
| `getCurrentUser()` undefined | ✅ | Added auth.php includes |
| `trim()` null deprecated warning | ✅ | Updated sanitize() function |
| Missing `is_active` columns | ⚠️ | Run database_fixes.sql |
| Missing `is_featured` column | ⚠️ | Run database_fixes.sql |
| Missing `end_date` column | ⚠️ | Run database_fixes.sql |
| "Loading SPARK..." issue | ⚠️ | Check browser console & database |

✅ = Already fixed in code
⚠️ = Requires manual action (run SQL file)

---

## 🆘 Still Having Issues?

If you still see errors after applying all fixes:

1. **Share the exact error message** - Copy the full error from browser or PHP logs
2. **Check browser console** - Press F12 and share any JavaScript errors
3. **Verify database** - Make sure all tables exist and columns are added
4. **Check PHP version** - SPARK requires PHP 7.4 or higher

---

**Last Updated:** 2025-11-15
