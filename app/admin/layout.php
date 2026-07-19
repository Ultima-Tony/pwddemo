<?php
/** Homepage Layout — reorder (up/down) + enable/disable homepage sections. */
require_once __DIR__ . '/_layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $do = $_POST['do'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    if ($do === 'toggle') {
        db()->prepare('UPDATE sections SET is_enabled = 1 - is_enabled WHERE id=?')->execute([$id]);
    } elseif ($do === 'up' || $do === 'down') {
        $rows = db()->query('SELECT id, sort_order FROM sections ORDER BY sort_order ASC, id ASC')->fetchAll();
        $pos = null;
        foreach ($rows as $i => $r) { if ((int) $r['id'] === $id) { $pos = $i; break; } }
        if ($pos !== null) {
            $swap = $do === 'up' ? $pos - 1 : $pos + 1;
            if ($swap >= 0 && $swap < count($rows)) {
                $a = $rows[$pos]; $b = $rows[$swap];
                $u = db()->prepare('UPDATE sections SET sort_order=? WHERE id=?');
                $u->execute([$b['sort_order'], $a['id']]);
                $u->execute([$a['sort_order'], $b['id']]);
                // if orders were equal, force a difference
                if ($a['sort_order'] === $b['sort_order']) {
                    $u->execute([$a['sort_order'] + ($do === 'up' ? -1 : 1), $a['id']]);
                }
            }
        }
    }
    header('Location: ' . admin_url('layout'));
    return;
}

$rows = db()->query('SELECT * FROM sections ORDER BY sort_order ASC, id ASC')->fetchAll();

admin_head('Homepage Layout');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Homepage Layout</h2><a class="btn sec" href="<?= url('') ?>" target="_blank">Preview &nearr;</a></div>
<div class="card">
  <p class="muted">Reorder the homepage sections and toggle their visibility. Changes apply immediately.</p>
  <table>
    <tr><th>Order</th><th>Section</th><th>Visible</th><th></th></tr>
    <?php foreach ($rows as $i => $s): ?>
    <tr>
      <td class="muted"><?= $i + 1 ?></td>
      <td><strong><?= e($s['label'] ?: $s['section_key']) ?></strong> <span class="muted">(<?= e($s['section_key']) ?>)</span></td>
      <td>
        <form method="post" style="display:inline">
          <?= csrf_field() ?><input type="hidden" name="do" value="toggle"><input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
          <button class="btn sm <?= $s['is_enabled'] ? '' : 'sec' ?>" type="submit"><?= $s['is_enabled'] ? 'Visible' : 'Hidden' ?></button>
        </form>
      </td>
      <td>
        <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="do" value="up"><input type="hidden" name="id" value="<?= (int) $s['id'] ?>"><button class="btn sm sec" type="submit" <?= $i === 0 ? 'disabled' : '' ?>>↑</button></form>
        <form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="do" value="down"><input type="hidden" name="id" value="<?= (int) $s['id'] ?>"><button class="btn sm sec" type="submit" <?= $i === count($rows) - 1 ? 'disabled' : '' ?>>↓</button></form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php admin_foot();
