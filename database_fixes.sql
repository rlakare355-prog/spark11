-- SPARK Platform - Database Fixes for XAMPP
-- Run this script in phpMyAdmin or MySQL command line to fix missing columns

USE spark_platform;

-- ============================================================================
-- Fix research_projects table
-- ============================================================================

-- Add is_active column if it doesn't exist
ALTER TABLE research_projects 
ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1 AFTER status;

-- Add is_featured column if it doesn't exist  
ALTER TABLE research_projects 
ADD COLUMN IF NOT EXISTS is_featured TINYINT(1) DEFAULT 0 AFTER is_active;

-- Add end_date column if it doesn't exist
ALTER TABLE research_projects 
ADD COLUMN IF NOT EXISTS end_date DATE DEFAULT NULL AFTER updated_at;

-- Add indexes for better performance
ALTER TABLE research_projects 
ADD INDEX IF NOT EXISTS idx_is_active (is_active);

ALTER TABLE research_projects 
ADD INDEX IF NOT EXISTS idx_is_featured (is_featured);

ALTER TABLE research_projects 
ADD INDEX IF NOT EXISTS idx_end_date (end_date);

-- Update existing records to be active
UPDATE research_projects SET is_active = 1 WHERE is_active IS NULL;
UPDATE research_projects SET is_featured = 0 WHERE is_featured IS NULL;

-- ============================================================================
-- Fix opportunities table
-- ============================================================================

-- Add is_active column if it doesn't exist
ALTER TABLE opportunities 
ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1 AFTER is_featured;

-- Add index
ALTER TABLE opportunities 
ADD INDEX IF NOT EXISTS idx_is_active_opp (is_active);

-- Update existing records to be active
UPDATE opportunities SET is_active = 1 WHERE is_active IS NULL;

-- ============================================================================
-- Verify the changes
-- ============================================================================

-- Check research_projects structure
SHOW COLUMNS FROM research_projects LIKE 'is_active';
SHOW COLUMNS FROM research_projects LIKE 'is_featured';
SHOW COLUMNS FROM research_projects LIKE 'end_date';

-- Check opportunities structure  
SHOW COLUMNS FROM opportunities LIKE 'is_active';

-- Display success message
SELECT 'Database fixes applied successfully!' as Status;
