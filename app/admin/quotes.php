<?php
/** Quote inbox. ?id=N opens one (and marks read). */
require_once __DIR__ . '/_layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $do = $_POST['do'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($do === 'delete') {
        db()->prepare('DELETE FROM quotes WHERE id=?')->execute([$id]);
        admin_flash('Quote deleted.');
        header('Location: ' . admin_url('quotes'));
        return;
    }
    if ($do === 'toggle') {
        db()->prepare('UPDATE quotes SET is_read = 1 - is_read WHERE id=?')->execute([$id]);
    }
    header('Location: ' . admin_url('quotes' . ($id ? '?id=' . $id : '')));
    return;
}

$view = null;
if (isset($_GET['id'])) {
    $view = db()->query('SELECT * FROM quotes WHERE id=' . (int) $_GET['id'])->fetch();
    if ($view && !$view['is_read']) {
        db()->prepare('UPDATE quotes SET is_read=1 WHERE id=?')->execute([(int) $view['id']]);
        $view['is_read'] = 1;
    }
}

admin_head('Quotes');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Quote Inbox</h2></div>

<?php if ($view): ?>
<div class="card">
  <p><a href="<?= e(admin_url('quotes')) ?>">&larr; Back to inbox</a></p>
  <h3><?= e($view['name']) ?> <span class="muted">&lt;<?= e($view['email']) ?>&gt;</span></h3>
  <p class="muted"><?= e(date('F j, Y g:ia', strtotime($view['created_at']))) ?> · source: <?= e($view['source'] ?: '—') ?></p>
  <table>
    <tr><th>Phone</th><td><?= e($view['phone'] ?: '—') ?></td></tr>
    <tr><th>Service</th><td><?= e($view['service'] ?: '—') ?></td></tr>
  </table>
  <p style="margin-top:16px;white-space:pre-wrap"><?= e($view['message']) ?></p>
  <p style="margin-top:16px">
    <a class="btn sec" href="mailto:<?= e($view['email']) ?>">Reply by email</a>
    <form method="post" style="display:inline" onsubmit="return confirm('Delete this quote?')">
      <?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int) $view['id'] ?>">
      <button class="btn danger" type="submit">Delete</button>
    </form>
  </p>
</div>
<?php else: ?>
<div class="card">
  <table>
    <tr><th>Name</th><th>Service</th><th>Received</th><th></th></tr>
    <?php $all = db()->query('SELECT * FROM quotes ORDER BY created_at DESC')->fetchAll();
    if (!$all): ?><tr><td colspan="4" class="muted">No quote requests yet.</td></tr><?php endif; ?>
    <?php foreach ($all as $q): ?>
    <tr>
      <td><a href="<?= e(admin_url('quotes?id=' . $q['id'])) ?>"><?= e($q['name']) ?></a><?php if (!$q['is_read']): ?> <span class="pill new">new</span><?php endif; ?></td>
      <td><?= e($q['service'] ?: '—') ?></td>
      <td class="muted"><?= e(date('M j, Y g:ia', strtotime($q['created_at']))) ?></td>
      <td><a class="btn sm sec" href="<?= e(admin_url('quotes?id=' . $q['id'])) ?>">Open</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php endif; ?>
<?php admin_foot();
