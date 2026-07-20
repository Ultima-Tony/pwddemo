-- 001-temp-logo.sql
-- Point the logo setting at the new temporary SVG logo (public/assets/img/logo.svg).
-- Safe to run on the live DB without re-importing.
UPDATE settings SET setting_value = 'assets/img/logo.svg' WHERE setting_key = 'logo';
