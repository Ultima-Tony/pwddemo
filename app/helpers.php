<?php
/**
 * All content + URL + SEO + edit-UI helpers.
 * Loaded by the router before any view is rendered.
 */

require_once __DIR__ . '/auth.php';

// ---------------------------------------------------------------------------
// Escaping + URLs
// ---------------------------------------------------------------------------

/** HTML-escape. */
function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/** Site runs at docroot, so the base path is always '/'. */
function base_url(): string
{
    return '/';
}

/** Root-absolute internal page URL. url('about') => '/about', url('') => '/'. */
function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return '/' . $path;
}

/**
 * Admin URL honouring the (renameable) ADMIN_DIR. Root-absolute so it works
 * both on front-end pages (with <base href="/">) and on admin pages (no base),
 * and in Location: redirects. e.g. admin_url('settings') => '/admin/settings'.
 */
function admin_url(string $path = ''): string
{
    $dir  = trim(ADMIN_DIR, '/');
    $path = ltrim($path, '/');
    return '/' . $dir . ($path !== '' ? '/' . $path : '');
}

/**
 * Resolve an asset/DB-image path for output. Kept RELATIVE (no leading slash)
 * so <base href="/"> resolves it correctly at any URL depth. Absolute URLs
 * (http/https, protocol-relative) and data: URIs pass through untouched.
 */
function img(?string $path, string $fallback = ''): string
{
    $path = trim((string) $path);
    if ($path === '') {
        $path = $fallback;
    }
    if ($path === '') {
        return '';
    }
    if (preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, 'data:')) {
        return $path;
    }
    return ltrim($path, '/');
}

/**
 * Root-absolute image URL for contexts WITHOUT <base href="/"> — i.e. the admin
 * pages, which live at /admin/... A relative path there would resolve against
 * /admin/. Remote (http/protocol-relative) and data: URIs pass through.
 */
function img_url(?string $path, string $fallback = ''): string
{
    $p = img($path, $fallback);
    if ($p === '' || preg_match('#^(https?:)?//#i', $p) || str_starts_with($p, 'data:')) {
        return $p;
    }
    return '/' . ltrim($p, '/');
}

/** Absolute origin (scheme + host), used for canonical/OG/sitemap. */
function site_origin(): string
{
    $https  = FORCE_HTTPS || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $scheme = $https ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'homedemo.prairiewebdesign.ca';
    return $scheme . '://' . $host;
}

/** Absolute URL from an internal path. */
function abs_url(string $path = ''): string
{
    return site_origin() . url($path);
}

/** A URL-safe slug. */
function slugify(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    if (function_exists('iconv')) {
        $text = @iconv('UTF-8', 'ASCII//TRANSLIT', $text) ?: $text;
    }
    $text = strtolower(preg_replace('~[^-\w]+~', '', $text));
    return $text ?: 'item';
}

// ---------------------------------------------------------------------------
// Settings
// ---------------------------------------------------------------------------

/** All settings as [key => value], cached per request. */
function settings(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }
    $cache = [];
    try {
        foreach (db()->query('SELECT setting_key, setting_value FROM settings') as $r) {
            $cache[$r['setting_key']] = $r['setting_value'];
        }
    } catch (Throwable $e) {
        $cache = [];
    }
    return $cache;
}

/** One setting with fallback. */
function setting(string $key, string $default = ''): string
{
    $all = settings();
    $val = $all[$key] ?? '';
    return ($val === '' || $val === null) ? $default : $val;
}

/** Boolean setting (toggle input_type stores '1'/'0'). */
function setting_on(string $key): bool
{
    return setting($key, '0') === '1';
}

// ---------------------------------------------------------------------------
// Content blocks + items + posts + sections
// ---------------------------------------------------------------------------

/** One-off page section by block_key. Returns row or empty defaults. */
function block(string $key): array
{
    static $cache = [];
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }
    $stmt = db()->prepare('SELECT * FROM content_blocks WHERE block_key = ? LIMIT 1');
    $stmt->execute([$key]);
    $row = $stmt->fetch() ?: [];
    $defaults = ['block_key' => $key, 'label' => '', 'eyebrow' => '', 'heading' => '',
        'body' => '', 'image' => '', 'image2' => '', 'extra' => ''];
    return $cache[$key] = array_merge($defaults, $row);
}

/** Repeating cards for a section, ordered. */
function items(string $section, bool $only_active = true): array
{
    static $cache = [];
    $ck = $section . ($only_active ? ':1' : ':0');
    if (isset($cache[$ck])) {
        return $cache[$ck];
    }
    $sql = 'SELECT * FROM items WHERE section = ?';
    if ($only_active) {
        $sql .= ' AND is_active = 1';
    }
    $sql .= ' ORDER BY sort_order ASC, id ASC';
    $stmt = db()->prepare($sql);
    $stmt->execute([$section]);
    return $cache[$ck] = $stmt->fetchAll();
}

/** A single item by id. */
function item(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM items WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/** Published blog posts (optionally limited). */
function posts(?int $limit = null): array
{
    $sql = 'SELECT * FROM posts WHERE is_published = 1 ORDER BY published_at DESC, id DESC';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

/** A single published post by slug. */
function post_by_slug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM posts WHERE slug = ? AND is_published = 1 LIMIT 1');
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

/** Homepage sections in display order (enabled only, unless $all). */
function sections_layout(bool $all = false): array
{
    $sql = 'SELECT * FROM sections';
    if (!$all) {
        $sql .= ' WHERE is_enabled = 1';
    }
    $sql .= ' ORDER BY sort_order ASC, id ASC';
    return db()->query($sql)->fetchAll();
}

/** Is a homepage section enabled? */
function section_enabled(string $key): bool
{
    static $map = null;
    if ($map === null) {
        $map = [];
        foreach (sections_layout(true) as $s) {
            $map[$s['section_key']] = (int) $s['is_enabled'] === 1;
        }
    }
    return $map[$key] ?? true;
}

// ---------------------------------------------------------------------------
// Front-end inline editing (admin only)
// ---------------------------------------------------------------------------

/**
 * Invisible deep-link marker placed inside a .ltk-editable region. The floating
 * pencil JS (assets/js/site.js) reads the nearest .ltk-edit href to know where
 * to send the admin. Renders nothing for normal visitors.
 *
 * @param string $admin_path e.g. 'blocks?block=hero' or 'items?section=services'
 */
function edit_btn(string $admin_path, string $label = 'Edit'): string
{
    if (!admin_mode()) {
        return '';
    }
    return '<a class="ltk-edit" href="' . e(admin_url($admin_path)) . '" data-label="' . e($label) . '" aria-hidden="true" tabindex="-1"></a>';
}

/** Open an editable wrapper (adds the marker class the JS scans for). */
function editable_open(string $admin_path, string $label = 'Edit', string $tag = 'div', string $extra_class = ''): string
{
    if (!admin_mode()) {
        return '';
    }
    // When admin, we don't wrap (to avoid breaking template layout); instead we
    // mark the *existing* nearest section via a zero-size anchor. Kept for API
    // symmetry — most callers just use edit_btn() inside a template region.
    return '';
}

/** Fixed admin toolbar shown on front-end pages when logged in. */
function admin_bar(): string
{
    if (!admin_mode()) {
        return '';
    }
    $dash = e(admin_url(''));
    $out  = e(admin_url('logout'));
    $user = e($_SESSION['admin_username'] ?? 'admin');
    return <<<HTML
<div id="ltk-adminbar">
    <span class="ltk-ab-brand">✎ Edit mode</span>
    <span class="ltk-ab-user">{$user}</span>
    <a class="ltk-ab-link" href="{$dash}">Dashboard</a>
    <a class="ltk-ab-link" href="{$out}">Log out</a>
</div>
HTML;
}

// ---------------------------------------------------------------------------
// Quote / contact form
// ---------------------------------------------------------------------------

/**
 * Handle a quote/contact POST. Honeypot + CSRF, insert into `quotes`, then
 * best-effort email to the business. Returns ['ok'=>bool,'errors'=>[],'sent'=>bool].
 */
function submit_quote(string $source = 'contact'): array
{
    $res = ['ok' => false, 'errors' => [], 'sent' => false];
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return $res;
    }
    if (!csrf_check($_POST['csrf'] ?? null)) {
        $res['errors'][] = 'Your session expired — please try again.';
        return $res;
    }
    // Honeypot: real users never fill this hidden field.
    if (!empty($_POST['website'])) {
        $res['ok'] = true; // silently accept, drop
        return $res;
    }

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '')  $res['errors'][] = 'Please enter your name.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $res['errors'][] = 'Please enter a valid email.';
    if ($message === '') $res['errors'][] = 'Please enter a short message.';
    if ($res['errors']) {
        return $res;
    }

    $stmt = db()->prepare(
        'INSERT INTO quotes (name, email, phone, service, message, source, is_read, created_at)
         VALUES (?, ?, ?, ?, ?, ?, 0, NOW())'
    );
    $stmt->execute([$name, $email, $phone, $service, $message, $source]);
    $res['ok'] = true;

    // Best-effort email (never fatal if mail() unavailable).
    $to      = setting('contact_email', SITE_EMAIL);
    $subject = 'New quote request — ' . setting('site_name', SITE_NAME);
    $body    = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nService: {$service}\nSource: {$source}\n\n{$message}\n";
    $headers = 'From: ' . setting('site_name', SITE_NAME) . ' <' . $to . ">\r\n"
        . 'Reply-To: ' . $email . "\r\n";
    if (function_exists('mail') && $to) {
        $res['sent'] = @mail($to, $subject, $body, $headers);
    }
    return $res;
}

// ---------------------------------------------------------------------------
// SEO
// ---------------------------------------------------------------------------

/**
 * Render <title>, meta description, canonical, and Open Graph tags.
 * $o keys: title, description, path (internal), image (relative/abs), type.
 */
function seo_tags(array $o = []): string
{
    $site  = setting('site_name', SITE_NAME);
    $title = isset($o['title']) && $o['title'] !== '' ? $o['title'] . ' — ' . $site : $site . ' — ' . setting('tagline', 'Contracting & Home Improvement');
    $desc  = $o['description'] ?? setting('meta_description', 'Professional contracting and home improvement services.');
    $canon = abs_url($o['path'] ?? '');
    $type  = $o['type'] ?? 'website';
    $imgP  = $o['image'] ?? setting('og_image', '');
    $img   = $imgP !== '' ? (preg_match('#^https?://#i', $imgP) ? $imgP : site_origin() . '/' . ltrim(img($imgP), '/')) : '';

    $h  = '<title>' . e($title) . "</title>\n";
    $h .= '<meta name="description" content="' . e($desc) . "\">\n";
    $h .= '<link rel="canonical" href="' . e($canon) . "\">\n";
    $h .= '<meta property="og:site_name" content="' . e($site) . "\">\n";
    $h .= '<meta property="og:title" content="' . e($title) . "\">\n";
    $h .= '<meta property="og:description" content="' . e($desc) . "\">\n";
    $h .= '<meta property="og:type" content="' . e($type) . "\">\n";
    $h .= '<meta property="og:url" content="' . e($canon) . "\">\n";
    if ($img) {
        $h .= '<meta property="og:image" content="' . e($img) . "\">\n";
        $h .= "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    }
    return $h;
}

/** LocalBusiness JSON-LD assembled from settings. */
function localbusiness_jsonld(): string
{
    $data = [
        '@context' => 'https://schema.org',
        '@type'    => 'GeneralContractor',
        'name'     => setting('site_name', SITE_NAME),
        'url'      => site_origin() . '/',
        'telephone' => setting('contact_phone', ''),
        'email'    => setting('contact_email', SITE_EMAIL),
    ];
    $logo = setting('logo', '');
    if ($logo) {
        $data['logo'] = site_origin() . '/' . ltrim(img($logo), '/');
        $data['image'] = $data['logo'];
    }
    $addr = array_filter([
        '@type'           => 'PostalAddress',
        'streetAddress'   => setting('contact_address', ''),
        'addressLocality' => setting('contact_city', ''),
        'addressRegion'   => setting('contact_region', ''),
        'postalCode'      => setting('contact_postal', ''),
        'addressCountry'  => setting('contact_country', 'CA'),
    ]);
    if (count($addr) > 1) {
        $data['address'] = $addr;
    }
    $hours = setting('contact_hours', '');
    if ($hours) {
        $data['openingHours'] = $hours;
    }
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** FAQPage JSON-LD from a list of items with title (question) + body (answer). */
function faq_jsonld(array $faqs): string
{
    if (!$faqs) {
        return '';
    }
    $entities = [];
    foreach ($faqs as $f) {
        $entities[] = [
            '@type'          => 'Question',
            'name'           => $f['title'] ?? '',
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f['body'] ?? '')],
        ];
    }
    $data = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $entities];
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/** BlogPosting JSON-LD for a single post. */
function blogposting_jsonld(array $post): string
{
    $data = [
        '@context'      => 'https://schema.org',
        '@type'         => 'BlogPosting',
        'headline'      => $post['title'] ?? '',
        'description'   => $post['excerpt'] ?? '',
        'datePublished' => !empty($post['published_at']) ? date('c', strtotime($post['published_at'])) : null,
        'author'        => ['@type' => 'Organization', 'name' => $post['author'] ?: setting('site_name', SITE_NAME)],
        'publisher'     => ['@type' => 'Organization', 'name' => setting('site_name', SITE_NAME)],
        'mainEntityOfPage' => abs_url('blog/' . ($post['slug'] ?? '')),
    ];
    if (!empty($post['image'])) {
        $data['image'] = site_origin() . '/' . ltrim(img($post['image']), '/');
    }
    return '<script type="application/ld+json">' . json_encode(array_filter($data), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

/**
 * ElementsKit "eyebrow" — the small star-icon label above a section title.
 */
function ekit_eyebrow(string $text): string
{
    if ($text === '') {
        return '';
    }
    return '<div class="elementor-element elementor-icon-list--layout-traditional elementor-widget elementor-widget-icon-list" data-widget_type="icon-list.default">'
        . '<div class="elementor-widget-container"><ul class="elementor-icon-list-items"><li class="elementor-icon-list-item">'
        . '<span class="elementor-icon-list-icon"><svg aria-hidden="true" class="e-font-icon-svg e-fas-star-of-life" viewBox="0 0 480 512" xmlns="http://www.w3.org/2000/svg"><path d="M471.99 334.43L336.06 256l135.93-78.43c7.66-4.42 10.28-14.2 5.86-21.86l-32.02-55.43c-4.42-7.65-14.21-10.28-21.87-5.86l-135.93 78.43V16c0-8.84-7.17-16-16.01-16h-64.04c-8.84 0-16.01 7.16-16.01 16v156.86L56.04 94.43c-7.66-4.42-17.45-1.79-21.87 5.86L2.15 155.71c-4.42 7.65-1.8 17.44 5.86 21.86L143.94 256 8.01 334.43c-7.66 4.42-10.28 14.21-5.86 21.86l32.02 55.43c4.42 7.65 14.21 10.27 21.87 5.86l135.93-78.43V496c0 8.84 7.17 16 16.01 16h64.04c8.84 0 16.01-7.16 16.01-16V339.14l135.93 78.43c7.66 4.42 17.45 1.8 21.87-5.86l32.02-55.43c4.42-7.65 1.8-17.43-5.86-21.85z"></path></svg></span>'
        . '<span class="elementor-icon-list-text">' . e($text) . '</span></li></ul></div></div>';
}

/**
 * ElementsKit section heading. $heading_html may contain the <span><span>…</span></span>
 * accent markup, so it is emitted raw (author-controlled content).
 */
function ekit_heading(string $heading_html, string $align = 'left'): string
{
    $align = $align === 'center' ? 'text_center' : 'text_left';
    return '<div class="elementor-element elementor-widget elementor-widget-elementskit-heading" data-widget_type="elementskit-heading.default">'
        . '<div class="elementor-widget-container"><div class="ekit-wid-con"><div class="ekit-heading elementskit-section-title-wraper ' . $align . '">'
        . '<h2 class="ekit-heading--title elementskit-section-title ">' . $heading_html . '</h2></div></div></div></div>';
}

/** Render a view from app/views, passing $vars into scope. */
function render_view(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    $file = __DIR__ . '/views/' . $name . '.php';
    if (!is_file($file)) {
        http_response_code(500);
        echo 'View not found: ' . e($name);
        return;
    }
    require $file;
}
