# Migrations

`schema.sql` is the full schema + seed for a **fresh** import.

Whenever the live schema or seed needs to change *after* you've imported (so you don't
re-import and wipe your data), the change will be dropped here as a standalone,
idempotent `NNN-description.sql` you can run directly, e.g.:

```sql
-- 001-add-instagram-setting.sql
INSERT INTO settings (setting_key, setting_value, label, input_type, sort_order)
VALUES ('social_twitter', '', 'Twitter/X URL', 'url', 185)
ON DUPLICATE KEY UPDATE setting_key = setting_key;  -- no-op if it already exists
```

Nothing is needed here for the first deploy — just import `sql/schema.sql`.
