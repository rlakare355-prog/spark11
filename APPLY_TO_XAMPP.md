# Apply These Fixed Files to Your XAMPP

All code fixes have been applied in this Replit. Copy these fixed files to your XAMPP installation at `C:\xampp\htdocs\spark\`

## Fixed Files (Download and Replace)

### 1. includes/config.php
- Fixed `sanitize()` function for PHP 8.1+ compatibility

### 2. student/events.php
- Added `auth.php` include to fix getCurrentUser() error

### 3. student/research.php
- Added `auth.php` include to fix getCurrentUser() error

### 4. student/opportunities.php
- Added `auth.php` include to fix getCurrentUser() error

### 5. student/certificates.php
- Added `auth.php` include to fix getCurrentUser() error

### 6. admin/index.php
- Added `auth.php` include to fix getCurrentUser() error

---

## How to Apply to XAMPP

### Option 1: Download Individual Files
1. In Replit, click on each file listed above
2. Copy the entire content (Ctrl+A, Ctrl+C)
3. Open the same file in your XAMPP folder
4. Replace all content with the copied code
5. Save the file

### Option 2: Download Entire Project
1. Download this entire Replit project as ZIP
2. Extract it
3. Copy these 6 files to your XAMPP installation
4. Replace the existing files

---

## Database Fixes (REQUIRED)

Run this SQL in phpMyAdmin:

```sql
USE spark_platform;

ALTER TABLE research_projects ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER status;
ALTER TABLE research_projects ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER is_active;
ALTER TABLE research_projects ADD COLUMN end_date DATE DEFAULT NULL AFTER updated_at;
ALTER TABLE research_projects ADD INDEX idx_is_active (is_active);
ALTER TABLE research_projects ADD INDEX idx_is_featured (is_featured);
ALTER TABLE research_projects ADD INDEX idx_end_date (end_date);

ALTER TABLE opportunities ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER is_featured;
ALTER TABLE opportunities ADD INDEX idx_is_active_opp (is_active);

UPDATE research_projects SET is_active = 1;
UPDATE opportunities SET is_active = 1;
```

---

## After Applying All Fixes

1. Restart Apache in XAMPP (optional)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Visit: http://localhost/spark/student/

All pages should now work without errors!

---

## Public Pages (No Login Required)
- ✅ Home - student/index.php
- ✅ Events - student/events.php
- ✅ Research - student/research.php
- ✅ Opportunities - student/opportunities.php
- ✅ Gallery - student/gallery.php
- ✅ Contact - student/contact.php
- ✅ Team - student/team.php

## Protected Pages (Login Required)
- 🔒 Dashboard
- 🔒 Profile
- 🔒 Certificates
- 🔒 Calendar
- 🔒 Attendance
