<?php
/**
 * Front controller / router for Demo Contracting Ltd.
 * Every non-file request under / lands here (see .htaccess).
 */

// Buffer all output so session_start()/header() can always send headers,
// even if a stale config.php on the server has a stray trailing byte.
ob_start();

require_once __DIR__ . '/../app/helpers.php';

// Normalise the request path into clean segments.
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$path = trim(rawurldecode($path), '/');
$segments = $path === '' ? [] : explode('/', $path);
$head = $segments[0] ?? '';

// ---- Dynamic robots.txt + sitemap.xml -------------------------------------
if ($path === 'robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');
    // Deliberately do NOT name the (obscured) admin folder here.
    echo "User-agent: *\n";
    echo "Allow: /\n";
    echo "Disallow: /assets/uploads/\n";
    echo 'Sitemap: ' . site_origin() . "/sitemap.xml\n";
    exit;
}

if ($path === 'sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');
    $urls = [['loc' => abs_url(''), 'pri' => '1.0']];
    foreach (['about', 'services', 'pricing', 'projects', 'team', 'testimonials', 'faqs', 'blog', 'contact'] as $p) {
        $urls[] = ['loc' => abs_url($p), 'pri' => '0.8'];
    }
    foreach (items('services') as $s) {
        $urls[] = ['loc' => abs_url('services/' . $s['id'] . '/' . slugify($s['title'])), 'pri' => '0.7'];
    }
    foreach (items('projects') as $pr) {
        $urls[] = ['loc' => abs_url('projects/' . $pr['id'] . '/' . slugify($pr['title'])), 'pri' => '0.6'];
    }
    foreach (posts() as $post) {
        $urls[] = ['loc' => abs_url('blog/' . $post['slug']), 'pri' => '0.6'];
    }
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        echo '  <url><loc>' . e($u['loc']) . '</loc><priority>' . $u['pri'] . "</priority></url>\n";
    }
    echo '</urlset>';
    exit;
}

// Start the session BEFORE any page output so is_admin() (admin bar + edit
// pencils) works reliably on every page — including the homepage, where the
// large <head> would otherwise push session_start() past headers-sent.
// (Placed after the robots/sitemap early-exits so bots don't spawn sessions.)
auth_boot();

// ---- Page routing ---------------------------------------------------------
$route_id   = null;   // exposed to detail views
$route_slug = null;

switch ($head) {
    case '':
        $view = 'home';
        break;

    case 'about':
        $view = 'about';
        break;

    case 'services':
        if (isset($segments[1]) && ctype_digit($segments[1])) {
            $route_id   = (int) $segments[1];
            $route_slug = $segments[2] ?? '';
            $view = 'service_detail';
        } else {
            $view = 'services';
        }
        break;

    case 'pricing':
        $view = 'pricing';
        break;

    case 'projects':
        if (isset($segments[1]) && ctype_digit($segments[1])) {
            $route_id   = (int) $segments[1];
            $route_slug = $segments[2] ?? '';
            $view = 'project_detail';
        } else {
            $view = 'projects';
        }
        break;

    case 'team':
        $view = 'team';
        break;

    case 'testimonials':
        $view = 'testimonials';
        break;

    case 'faqs':
    case 'faq':
        $view = 'faqs';
        break;

    case 'blog':
        if (isset($segments[1]) && $segments[1] !== '') {
            $route_slug = $segments[1];
            $view = 'blog_post';
        } else {
            $view = 'blog';
        }
        break;

    case 'contact':
        $view = 'contact';
        break;

    default:
        http_response_code(404);
        $view = '404';
        break;
}

render_view($view, ['route_id' => $route_id, 'route_slug' => $route_slug]);
