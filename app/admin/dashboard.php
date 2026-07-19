<?php
/** Admin dashboard. */
require_once __DIR__ . '/_layout.php';

$counts = [
    'Services'      => (int) db()->query("SELECT COUNT(*) FROM items WHERE section='services'")->fetchColumn(),
    'Projects'      => (int) db()->query("SELECT COUNT(*) FROM items WHERE section='projects'")->fetchColumn(),
    'Blog posts'    => (int) db()->query('SELECT COUNT(*) FROM posts')->fetchColumn(),
    'Quotes'        => (int) db()->query('SELECT COUNT(*) FROM quotes')->fetchColumn(),
];
$unread = (int) db()->query('SELECT COUNT(*) FROM quotes WHERE is_read=0')->fetchColumn();
$recent = db()->query('SELECT * FROM quotes ORDER BY created_at DESC LIMIT 5')->fetchAll();

admin_head('Dashboard');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Dashboard</h2><a class="btn sec" href="<?= url('') ?>" target="_blank">Open site &nearr;</a></div>

<div class="row">
  <?php foreach ($counts as $lbl => $n): ?>
  <div class="card" style="text-align:center">
    <div style="font-size:34px;font-weight:700;color:#f2792b"><?= $n ?></div>
    <div class="muted"><?= e($lbl) ?></div>
  </div>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="topbar"><h3 style="margin:0">Recent quote requests <?php if ($unread): ?><span class="pill new"><?= $unread ?> new</span><?php endif; ?></h3><a href="<?= e(admin_url('quotes')) ?>">View all</a></div>
  <?php if (!$recent): ?><p class="muted">No quote requests yet.</p><?php else: ?>
  <table>
    <tr><th>Name</th><th>Service</th><th>When</th><th></th></tr>
    <?php foreach ($recent as $q): ?>
    <tr>
      <td><?= e($q['name']) ?><?php if (!$q['is_read']): ?> <span class="pill new">new</span><?php endif; ?></td>
      <td><?= e($q['service'] ?: '—') ?></td>
      <td class="muted"><?= e(date('M j, g:ia', strtotime($q['created_at']))) ?></td>
      <td><a href="<?= e(admin_url('quotes?id=' . $q['id'])) ?>">Open</a></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php endif; ?>
</div>

<div class="card">
  <h3 style="margin-top:0">Quick edit</h3>
  <p><a class="btn sm" href="<?= e(admin_url('settings')) ?>">Site settings</a>
     <a class="btn sm" href="<?= e(admin_url('items?section=services')) ?>">Services</a>
     <a class="btn sm" href="<?= e(admin_url('posts')) ?>">Blog</a>
     <a class="btn sm" href="<?= e(admin_url('layout')) ?>">Homepage layout</a></p>
</div>
<?php admin_foot();
