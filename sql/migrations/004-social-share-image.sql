-- 004-social-share-image.sql
-- Set a branded social-share (Open Graph) image so links show a good preview
-- when texted or posted in Discord/Slack/Facebook/etc. Safe to re-run.
-- (Swap to assets/img/og-image.png after generating it with og-card.html for
--  guaranteed image thumbnails on Discord/iMessage.)
UPDATE settings SET setting_value = 'assets/img/og-image.svg' WHERE setting_key = 'og_image';
