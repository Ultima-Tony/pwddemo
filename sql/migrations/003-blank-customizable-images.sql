-- 003-blank-customizable-images.sql
-- Clears every customizable image so they start empty and you replace them all
-- in the admin. The logo is intentionally left alone. Safe to re-run.
UPDATE content_blocks SET image = '', image2 = '', bg_image = '';
UPDATE items          SET image = '';
UPDATE posts          SET image = '';
UPDATE settings       SET setting_value = '' WHERE setting_key = 'og_image';
