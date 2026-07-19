<?php
/**
 * PDO singleton + constant fallbacks.
 *
 * IMPORTANT: the user keeps their own app/config.php on the server. If that
 * copy is older than the code, it may be missing newer constants. Every
 * constant the app relies on gets a safe fallback HERE so a stale config can
 * never fatal the site. When you add a new constant to config.php, add its
 * fallback below too.
 */

require_once __DIR__ . '/config.php';

// ---- Fallbacks for anything a stale config.php might not define -----------
if (!defined('DB_HOST'))      define('DB_HOST', 'localhost');
if (!defined('DB_NAME'))      define('DB_NAME', 'homedemo');
if (!defined('DB_USER'))      define('DB_USER', 'root');
if (!defined('DB_PASS'))      define('DB_PASS', '');
if (!defined('DB_CHARSET'))   define('DB_CHARSET', 'utf8mb4');
if (!defined('ADMIN_DIR'))    define('ADMIN_DIR', 'admin');
if (!defined('SESSION_NAME')) define('SESSION_NAME', 'homedemo_sess');
if (!defined('UPLOAD_DIR'))   define('UPLOAD_DIR', __DIR__ . '/../public/assets/uploads');
if (!defined('UPLOAD_URL'))   define('UPLOAD_URL', 'assets/uploads');
if (!defined('SITE_NAME'))    define('SITE_NAME', 'Demo Contracting Ltd');
if (!defined('SITE_EMAIL'))   define('SITE_EMAIL', 'info@homedemo.prairiewebdesign.ca');
if (!defined('FORCE_HTTPS'))  define('FORCE_HTTPS', false);

/**
 * Return the shared PDO connection (prepared statements, exceptions on error).
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        // Don't leak credentials/queries to visitors.
        http_response_code(500);
        if (ini_get('display_errors')) {
            echo 'Database connection failed: ' . htmlspecialchars($e->getMessage());
        } else {
            echo 'The site is temporarily unavailable. Please try again shortly.';
        }
        exit;
    }
    return $pdo;
}
