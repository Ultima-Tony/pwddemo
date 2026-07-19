<?php
/** Items CRUD, grouped by section. ?section=KEY filters; ?id=N edits; ?id=new adds. */
require_once __DIR__ . '/_layout.php';

$sectionsList = db()->query('SELECT DISTINCT section FROM items ORDER BY section')->fetchAll(PDO::FETCH_COLUMN);
$section = preg_replace('/[^a-z0-9_]/i', '', $_GET['section'] ?? ($sectionsList[0] ?? 'services'));

// ---- POST: save or delete ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $do = $_POST['do'] ?? 'save';
    if ($do === 'delete') {
        $del = db()->prepare('DELETE FROM items WHERE id=?');
        $del->execute([(int) ($_POST['id'] ?? 0)]);
        admin_flash('Item deleted.');
    } else {
        $id  = (int) ($_POST['id'] ?? 0);
        $cur = $id ? (item($id) ?? []) : [];
        $image = admin_handle_upload('image_file', $_POST['image'] ?? ($cur['image'] ?? ''));
        $data = [
            preg_replace('/[^a-z0-9_]/i', '', $_POST['section'] ?? $section),
            trim($_POST['title'] ?? ''), trim($_POST['subtitle'] ?? ''), trim($_POST['body'] ?? ''),
            $image, trim($_POST['icon'] ?? ''), trim($_POST['value'] ?? ''), trim($_POST['url'] ?? ''),
            (int) ($_POST['sort_order'] ?? 0), isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($id) {
            $stmt = db()->prepare('UPDATE items SET section=?,title=?,subtitle=?,body=?,image=?,icon=?,value=?,url=?,sort_order=?,is_active=? WHERE id=?');
            $stmt->execute([...$data, $id]);
            admin_flash('Item updated.');
        } else {
            $stmt = db()->prepare('INSERT INTO items (section,title,subtitle,body,image,icon,value,url,sort_order,is_active) VALUES (?,?,?,?,?,?,?,?,?,?)');
            $stmt->execute($data);
            admin_flash('Item created.');
        }
        $section = $data[0];
    }
    header('Location: ' . admin_url('items?section=' . $section));
    return;
}

// ---- Edit form ----
$editing = null;
if (isset($_GET['id'])) {
    $editing = $_GET['id'] === 'new' ? ['id' => 0, 'section' => $section, 'title' => '', 'subtitle' => '', 'body' => '', 'image' => '', 'icon' => '', 'value' => '', 'url' => '', 'sort_order' => 0, 'is_active' => 1] : item((int) $_GET['id']);
}

admin_head('Items');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Items / Cards</h2></div>
<div class="card" style="padding:12px 22px">
  <?php foreach ($sectionsList as $s): ?>
    <a class="btn sm <?= $s === $section && !$editing ? '' : 'sec' ?>" href="<?= e(admin_url('items?section=' . $s)) ?>"><?= e($s) ?></a>
  <?php endforeach; ?>
</div>

<?php if ($editing): ?>
<form method="post" enctype="multipart/form-data" class="card">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= (int) $editing['id'] ?>">
  <h3 style="margin-top:0"><?= $editing['id'] ? 'Edit' : 'New' ?> item</h3>
  <div class="row">
    <div><label>Section</label><input type="text" name="section" value="<?= e($editing['section']) ?>"></div>
    <div><label>Sort order</label><input type="number" name="sort_order" value="<?= (int) $editing['sort_order'] ?>"></div>
  </div>
  <label>Title</label><input type="text" name="title" value="<?= e($editing['title']) ?>">
  <label>Subtitle</label><input type="text" name="subtitle" value="<?= e($editing['subtitle']) ?>">
  <label>Body</label><textarea name="body"><?= e($editing['body']) ?></textarea>
  <div class="row">
    <div><label>Icon <span class="muted">(e.g. fas fa-bolt or icon-check)</span></label><input type="text" name="icon" value="<?= e($editing['icon']) ?>"></div>
    <div><label>Value <span class="muted">(price / number / flag)</span></label><input type="text" name="value" value="<?= e($editing['value']) ?>"></div>
    <div><label>URL</label><input type="text" name="url" value="<?= e($editing['url']) ?>"></div>
  </div>
  <label>Image path</label><input type="text" name="image" value="<?= e($editing['image']) ?>">
  <?php if ($editing['image']): ?><img class="thumb" src="<?= e(img($editing['image'])) ?>" style="margin-top:8px;width:110px;height:70px"><?php endif; ?>
  <label class="muted">…or upload</label><input type="file" name="image_file" accept="image/*">
  <p style="margin-top:12px"><label class="switch"><input type="checkbox" name="is_active" value="1" <?= $editing['is_active'] ? 'checked' : '' ?>> Active (visible)</label></p>
  <p><button class="btn" type="submit">Save</button> <a class="btn sec" href="<?= e(admin_url('items?section=' . $editing['section'])) ?>">Cancel</a></p>
</form>
<?php else: ?>
<div class="card">
  <div class="topbar"><h3 style="margin:0">Section: <?= e($section) ?></h3><a class="btn sm" href="<?= e(admin_url('items?section=' . $section . '&id=new')) ?>">+ Add item</a></div>
  <table>
    <tr><th></th><th>Title</th><th>Sort</th><th>Active</th><th></th></tr>
    <?php foreach (items($section, false) as $it): ?>
    <tr>
      <td><?php if ($it['image']): ?><img class="thumb" src="<?= e(img($it['image'])) ?>"><?php endif; ?></td>
      <td><?= $it['title'] ?: '<span class="muted">(untitled)</span>' ?><?php if ($it['subtitle']): ?><div class="muted"><?= e($it['subtitle']) ?></div><?php endif; ?></td>
      <td><?= (int) $it['sort_order'] ?></td>
      <td><?= $it['is_active'] ? '<span class="pill">yes</span>' : '<span class="muted">no</span>' ?></td>
      <td>
        <a class="btn sm sec" href="<?= e(admin_url('items?section=' . $section . '&id=' . $it['id'])) ?>">Edit</a>
        <form method="post" style="display:inline" onsubmit="return confirm('Delete this item?')">
          <?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int) $it['id'] ?>">
          <button class="btn sm danger" type="submit">Del</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php endif; ?>
<?php admin_foot();
