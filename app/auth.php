<?php
/**
 * Sessions, CSRF, and admin login.
 */

require_once __DIR__ . '/db.php';

/** Start the (single, named) session once. */
function auth_boot(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'path'     => '/',
    ]);
    session_start();
}

/** True when at least one admin has set a password (setup complete). */
function admin_exists(): bool
{
    try {
        return (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0;
    } catch (Throwable $e) {
        return false;
    }
}

/** Is the current visitor a logged-in admin? */
function is_admin(): bool
{
    auth_boot();
    return !empty($_SESSION['admin_id']);
}

/** Convenience alias used by the front-end edit UI. */
function admin_mode(): bool
{
    return is_admin();
}

/** Attempt login. Returns true on success. */
function admin_login(string $username, string $password): bool
{
    $stmt = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if ($row && password_verify($password, $row['password_hash'])) {
        auth_boot();
        session_regenerate_id(true);
        $_SESSION['admin_id']       = (int) $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        return true;
    }
    return false;
}

function admin_logout(): void
{
    auth_boot();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/** Redirect to login unless authenticated. Used by admin pages. */
function require_admin(): void
{
    if (!is_admin()) {
        header('Location: ' . admin_url('login'));
        exit;
    }
}

// ---- CSRF -----------------------------------------------------------------

function csrf_token(): string
{
    auth_boot();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Hidden input for forms. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

/** Validate a submitted token (timing-safe). */
function csrf_check(?string $token): bool
{
    auth_boot();
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

/** Verify CSRF on POST or die. */
function csrf_verify_post(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_check($_POST['csrf'] ?? null)) {
        http_response_code(419);
        exit('Invalid or expired form token. Go back and try again.');
    }
}
