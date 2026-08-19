-- 004-social-share-image.sql
-- Point the Open Graph image at the branded 1200x630 PNG card so links show a
-- real image preview when texted or posted in Discord/iMessage/Slack/Facebook.
-- (Also repairs the old og_image, which pointed at the deleted hero-home.jpg.)
-- Safe to re-run.
UPDATE settings SET setting_value = 'assets/img/og-image.png' WHERE setting_key = 'og_image';
