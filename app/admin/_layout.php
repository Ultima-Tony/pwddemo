<?php
/** Shared admin chrome. Call admin_head($title) then admin_foot(). */

function admin_head(string $title): void
{
    $b = e(admin_url(''));
    $nav = [
        ''         => 'Dashboard',
        'settings' => 'Settings',
        'blocks'   => 'Content Blocks',
        'items'    => 'Items / Cards',
        'posts'    => 'Blog Posts',
        'quotes'   => 'Quote Inbox',
        'layout'   => 'Homepage Layout',
    ];
    $cur = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '', '/');
    $seg = explode('/', $cur);
    $adminDir = trim(ADMIN_DIR, '/');
    $i = array_search($adminDir, $seg, true);
    $active = ($i !== false && isset($seg[$i + 1])) ? $seg[$i + 1] : '';
    ?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($title) ?> — Admin</title>
<style>
:root{--o:#f2792b;--d:#12181f}
*{box-sizing:border-box}
body{margin:0;font:15px/1.5 system-ui,Segoe UI,sans-serif;color:#1c2430;background:#f4f6f8}
a{color:var(--o);text-decoration:none}
.wrap{display:flex;min-height:100vh}
aside{width:230px;background:var(--d);color:#cfd8e0;padding:20px 0;flex-shrink:0}
aside h1{color:#fff;font-size:17px;margin:0 22px 20px}
aside h1 span{color:var(--o)}
aside a{display:block;color:#cfd8e0;padding:11px 22px}
aside a:hover,aside a.on{background:rgba(255,255,255,.07);color:#fff;border-left:3px solid var(--o)}
aside .logout{margin-top:20px;color:#8b98a5}
main{flex:1;padding:28px 34px;max-width:1000px}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:22px}
h2.page{margin:0;font-size:24px}
.card{background:#fff;border:1px solid #e4e8ec;border-radius:10px;padding:22px;margin-bottom:20px}
label{display:block;font-weight:600;margin:14px 0 6px}
input[type=text],input[type=email],input[type=tel],input[type=url],input[type=password],input[type=number],textarea,select{width:100%;padding:10px 12px;border:1px solid #d6dce1;border-radius:7px;font:inherit}
textarea{min-height:90px}
.btn{display:inline-block;background:var(--o);color:#fff;border:0;padding:11px 20px;border-radius:7px;cursor:pointer;font:inherit;font-weight:600}
.btn.sec{background:#e9edf1;color:#1c2430}
.btn.danger{background:#d9463e}
.btn.sm{padding:6px 12px;font-size:13px}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:10px 12px;border-bottom:1px solid #eef1f4;vertical-align:middle}
th{font-size:12px;text-transform:uppercase;letter-spacing:.04em;color:#7a8794}
.flash{padding:12px 16px;border-radius:8px;margin-bottom:18px}
.flash.ok{background:#e6f7ec;color:#116a35}
.flash.err{background:#fdecec;color:#8a1f1f}
.row{display:flex;gap:16px;flex-wrap:wrap}
.row>div{flex:1 1 220px}
.muted{color:#7a8794;font-size:13px}
.switch{display:inline-flex;align-items:center;gap:8px}
.pill{display:inline-block;padding:3px 9px;border-radius:20px;font-size:12px;background:#eef1f4}
.pill.new{background:#fde7c8;color:#8a4b00}
img.thumb{width:54px;height:40px;object-fit:cover;border-radius:5px}
</style></head><body>
<div class="wrap">
<aside>
  <h1>Demo<span>Contracting</span></h1>
  <?php foreach ($nav as $slug => $lbl): $href = $slug === '' ? $b : e(admin_url($slug)); ?>
  <a class="<?= $active === $slug || ($slug === '' && $active === '') ? 'on' : '' ?>" href="<?= $href ?>"><?= e($lbl) ?></a>
  <?php endforeach; ?>
  <a class="logout" href="<?= e(admin_url('logout')) ?>">&larr; Log out</a>
  <a class="logout" href="<?= url('') ?>" target="_blank">View site &nearr;</a>
</aside>
<main>
<?php
}

function admin_foot(): void
{
    echo "</main></div></body></html>";
}

/** Simple session flash. */
function admin_flash(?string $msg = null, string $type = 'ok'): ?array
{
    auth_boot();
    if ($msg !== null) {
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
        return null;
    }
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function admin_flash_render(): void
{
    $f = admin_flash();
    if ($f) {
        echo '<div class="flash ' . e($f['type']) . '">' . e($f['msg']) . '</div>';
    }
}

/** Handle an uploaded image field; returns stored relative path or existing value. */
function admin_handle_upload(string $field, string $existing = ''): string
{
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $existing;
    }
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        return $existing;
    }
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    if (!in_array($ext, $allowed, true)) {
        return $existing;
    }
    if (!is_dir(UPLOAD_DIR)) {
        @mkdir(UPLOAD_DIR, 0755, true);
    }
    $name = date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
    $dest = rtrim(UPLOAD_DIR, '/\\') . '/' . $name;
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        return rtrim(UPLOAD_URL, '/') . '/' . $name;
    }
    return $existing;
}
