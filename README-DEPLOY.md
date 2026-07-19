# Demo Contracting Ltd — deploy notes

Template: **Homi** (Eightheme) home-improvement Elementor kit, rebuilt as a
PDO/MySQL, front-controller PHP site. Windows-authored, deploy on Apache/Linux.

## Layout
```
homedemo/
├── app/                 # OUTSIDE docroot — secrets + templates
│   ├── config.php       # DB creds + constants (keep your server copy)
│   ├── db.php           # PDO singleton + constant fallbacks
│   ├── auth.php         # sessions, CSRF, login
│   ├── helpers.php      # content / URL / SEO / edit-UI helpers
│   ├── admin/           # admin handlers (dispatched by public/admin/index.php)
│   └── views/           # page templates + sections/ + partials/
├── public/              # DOCROOT — set your vhost here
│   ├── index.php        # front controller / router
│   ├── .htaccess        # clean URLs + asset caching
│   ├── admin/           # index.php + .htaccess (rename this dir to obscure)
│   └── assets/          # css / js / img / fonts / webfonts / uploads
└── sql/
    ├── schema.sql       # schema + seed content (import ONCE)
    └── migrations/      # standalone ALTER/INSERT snippets for live changes
```

## First deploy
1. Point the Apache vhost **DocumentRoot at `public/`**. Ensure `mod_rewrite`,
   `AllowOverride All`. Recommended: also `mod_expires`, `mod_deflate`, `mod_headers`.
2. Create a MySQL database + user, then import: `mysql -u USER -p DBNAME < sql/schema.sql`
3. Edit **`app/config.php`** with your real DB credentials. (Every constant also has a
   fallback in `app/db.php`, so a stale config never fatals the site.)
4. Make `public/assets/uploads/` writable by the web server (`chmod 775`).
5. Visit **`/admin/setup`** once → create the admin username + password. The page then
   locks itself permanently (no password is ever stored in SQL).
6. Log in at `/admin/login`. Edit Settings, Content Blocks, Items, Blog, and the
   Homepage Layout. When logged in, the public site shows hover **edit pencils**.

## Obscuring the admin
Rename `public/admin/` to something private (e.g. `public/manage-x7/`) and set
`define('ADMIN_DIR','manage-x7');` in `config.php`. All admin + edit links derive from
`ADMIN_DIR`; robots.txt never names it. The folder's own `.htaccess` travels with it.

## Notes
- `<base href="/">` is set, so DB image paths are stored **relative** (e.g.
  `assets/img/x.jpg`) and resolve at any URL depth. Uploads land in `assets/uploads/`.
- Emails from the quote form use `mail()` (best-effort). If your host needs SMTP, wire it
  into `submit_quote()` in `helpers.php`.
- Fonts (ElementsKit glyphs, Font Awesome, Manrope) and all section-background images were
  bundled locally under `assets/` — the site makes **no external requests** except the
  optional Google-Maps iframe on the contact page and the YouTube video popup.
- SEO: dynamic `/sitemap.xml` + `/robots.txt`, per-page title/description/canonical/OG,
  LocalBusiness + FAQPage + BlogPosting JSON-LD.
