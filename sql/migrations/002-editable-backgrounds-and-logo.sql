-- 002-editable-backgrounds-and-logo.sql
-- Run ONCE on the live DB (it adds a column, so don't run twice).
-- Adds editable section-background images + switches to the outlined logo.

-- 1) New column that holds each section's background image.
ALTER TABLE content_blocks ADD COLUMN bg_image VARCHAR(255) NULL AFTER extra;

-- 2) The counters bar has no heading block yet — add one so its background is editable.
INSERT INTO content_blocks (block_key, label) VALUES ('counters', 'Counters / stats bar')
  ON DUPLICATE KEY UPDATE label = VALUES(label);

-- 3) Seed the current backgrounds so nothing changes visually until you edit them.
UPDATE content_blocks SET bg_image = 'assets/img/bg/home-improvement.jpg'                          WHERE block_key = 'hero';
UPDATE content_blocks SET bg_image = 'assets/img/bg/diy-home-improvement-paint-e1750317921377.jpg' WHERE block_key = 'counters';
UPDATE content_blocks SET bg_image = 'assets/img/cta-bg.jpg'                                        WHERE block_key = 'cta_banner';
-- (contact_cta left blank so it keeps its solid navy panel; set an image there to override it.)

-- 4) Switch to the outlined logo (readable on the white header bar).
UPDATE settings SET setting_value = 'assets/img/logo-v3.svg' WHERE setting_key = 'logo';
