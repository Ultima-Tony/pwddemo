<?php
/** Settings editor — form auto-generated from the settings table. */
require_once __DIR__ . '/_layout.php';

$rows = db()->query('SELECT * FROM settings ORDER BY sort_order ASC, id ASC')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $upd = db()->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
    foreach ($rows as $r) {
        $k = $r['setting_key'];
        if ($r['input_type'] === 'toggle') {
            $val = isset($_POST['s'][$k]) ? '1' : '0';
        } else {
            $val = trim((string) ($_POST['s'][$k] ?? ''));
        }
        $upd->execute([$val, $k]);
    }
    admin_flash('Settings saved.');
    header('Location: ' . admin_url('settings'));
    return;
}

admin_head('Settings');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Site Settings</h2></div>
<form method="post" class="card">
  <?= csrf_field() ?>
  <?php foreach ($rows as $r): $k = $r['setting_key']; $v = $r['setting_value']; $t = $r['input_type']; ?>
    <label for="s-<?= e($k) ?>"><?= e($r['label'] ?: $k) ?> <span class="muted">(<?= e($k) ?>)</span></label>
    <?php if ($t === 'toggle'): ?>
      <div class="switch"><input type="checkbox" id="s-<?= e($k) ?>" name="s[<?= e($k) ?>]" value="1" <?= $v === '1' ? 'checked' : '' ?>> <span class="muted">Enabled</span></div>
    <?php elseif ($t === 'textarea'): ?>
      <textarea id="s-<?= e($k) ?>" name="s[<?= e($k) ?>]"><?= e($v) ?></textarea>
    <?php else: ?>
      <input type="<?= e($t) ?>" id="s-<?= e($k) ?>" name="s[<?= e($k) ?>]" value="<?= e($v) ?>">
    <?php endif; ?>
  <?php endforeach; ?>
  <p style="margin-top:20px"><button class="btn" type="submit">Save settings</button></p>
</form>
<?php admin_foot();
