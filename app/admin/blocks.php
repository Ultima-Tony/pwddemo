<?php
/** Content-blocks editor. ?block=KEY focuses one block. */
require_once __DIR__ . '/_layout.php';

$focus = preg_replace('/[^a-z0-9_-]/i', '', $_GET['block'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $key = preg_replace('/[^a-z0-9_-]/i', '', $_POST['block_key'] ?? '');
    if ($key) {
        $cur = block($key);
        $image  = admin_handle_upload('image_file', $_POST['image'] ?? $cur['image']);
        $image2 = admin_handle_upload('image2_file', $_POST['image2'] ?? $cur['image2']);
        $stmt = db()->prepare('UPDATE content_blocks SET eyebrow=?, heading=?, body=?, image=?, image2=?, extra=? WHERE block_key=?');
        $stmt->execute([
            trim($_POST['eyebrow'] ?? ''), trim($_POST['heading'] ?? ''), trim($_POST['body'] ?? ''),
            $image, $image2, trim($_POST['extra'] ?? ''), $key,
        ]);
        admin_flash('Block “' . $key . '” saved.');
    }
    header('Location: ' . admin_url('blocks' . ($focus ? '?block=' . $focus : '')));
    return;
}

$blocks = db()->query('SELECT * FROM content_blocks ORDER BY id ASC')->fetchAll();

admin_head('Content Blocks');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Content Blocks</h2></div>
<?php foreach ($blocks as $b): $open = ($focus === '' || $focus === $b['block_key']); ?>
<details class="card" <?= $open ? 'open' : '' ?> id="<?= e($b['block_key']) ?>">
  <summary style="cursor:pointer;font-weight:600"><?= e($b['label'] ?: $b['block_key']) ?> <span class="muted">(<?= e($b['block_key']) ?>)</span></summary>
  <form method="post" enctype="multipart/form-data" style="margin-top:14px">
    <?= csrf_field() ?>
    <input type="hidden" name="block_key" value="<?= e($b['block_key']) ?>">
    <label>Eyebrow</label><input type="text" name="eyebrow" value="<?= e($b['eyebrow']) ?>">
    <label>Heading <span class="muted">(may include &lt;span&gt;&lt;span&gt;accent&lt;/span&gt;&lt;/span&gt;)</span></label>
    <textarea name="heading"><?= e($b['heading']) ?></textarea>
    <label>Body</label><textarea name="body"><?= e($b['body']) ?></textarea>
    <div class="row">
      <div>
        <label>Image path</label><input type="text" name="image" value="<?= e($b['image']) ?>">
        <?php if ($b['image']): ?><img class="thumb" src="<?= e(img($b['image'])) ?>" style="margin-top:8px;width:110px;height:70px"><?php endif; ?>
        <label class="muted">…or upload</label><input type="file" name="image_file" accept="image/*">
      </div>
      <div>
        <label>Image 2 path</label><input type="text" name="image2" value="<?= e($b['image2']) ?>">
        <?php if ($b['image2']): ?><img class="thumb" src="<?= e(img($b['image2'])) ?>" style="margin-top:8px;width:110px;height:70px"><?php endif; ?>
        <label class="muted">…or upload</label><input type="file" name="image2_file" accept="image/*">
      </div>
    </div>
    <label>Extra <span class="muted">(badge / button label / misc)</span></label><input type="text" name="extra" value="<?= e($b['extra']) ?>">
    <p style="margin-top:16px"><button class="btn" type="submit">Save block</button></p>
  </form>
</details>
<?php endforeach; ?>
<?php admin_foot();
