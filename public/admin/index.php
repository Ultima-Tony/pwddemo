<?php
/**
 * Admin dispatcher. Clean URLs like /admin/settings, /admin/items?section=services.
 * Handlers live OUTSIDE docroot in app/admin/.
 */
require_once __DIR__ . '/../../app/helpers.php';
auth_boot();

// Work out the requested action = the path segment after the admin dir.
$path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '', '/');
$segs = $path === '' ? [] : explode('/', $path);
$adminDir = trim(ADMIN_DIR, '/');
$idx = array_search($adminDir, $segs, true);
$action = 'dashboard';
if ($idx !== false && isset($segs[$idx + 1]) && $segs[$idx + 1] !== '') {
    $action = $segs[$idx + 1];
}
$action = preg_replace('/[^a-z0-9_-]/', '', strtolower($action)) ?: 'dashboard';

// Public actions (no auth). Everything else requires login.
$public = ['setup', 'login', 'logout'];
$known  = ['setup', 'login', 'logout', 'dashboard', 'settings', 'blocks', 'items', 'posts', 'quotes', 'layout'];

if (!in_array($action, $known, true)) {
    $action = 'dashboard';
}
if (!in_array($action, $public, true)) {
    require_admin();
}

$handler = __DIR__ . '/../../app/admin/' . $action . '.php';
if (is_file($handler)) {
    require $handler;
} else {
    http_response_code(404);
    echo 'Unknown admin action.';
}
