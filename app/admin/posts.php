<?php
/** Blog posts CRUD. ?id=N edits, ?id=new adds. */
require_once __DIR__ . '/_layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify_post();
    $do = $_POST['do'] ?? 'save';
    if ($do === 'delete') {
        db()->prepare('DELETE FROM posts WHERE id=?')->execute([(int) ($_POST['id'] ?? 0)]);
        admin_flash('Post deleted.');
        header('Location: ' . admin_url('posts'));
        return;
    }
    $id    = (int) ($_POST['id'] ?? 0);
    $cur   = $id ? db()->query('SELECT * FROM posts WHERE id=' . $id)->fetch() : [];
    $title = trim($_POST['title'] ?? '');
    $slug  = trim($_POST['slug'] ?? '');
    if ($slug === '') { $slug = slugify($title); }
    else { $slug = slugify($slug); }
    $image = admin_handle_upload('image_file', $_POST['image'] ?? ($cur['image'] ?? ''));
    $pub   = isset($_POST['is_published']) ? 1 : 0;
    $pubAt = trim($_POST['published_at'] ?? '');
    $pubAt = $pubAt !== '' ? date('Y-m-d H:i:s', strtotime($pubAt)) : date('Y-m-d H:i:s');
    $fields = [$slug, $title, trim($_POST['excerpt'] ?? ''), (string) ($_POST['body'] ?? ''), $image, trim($_POST['author'] ?? ''), $pub, $pubAt];
    try {
        if ($id) {
            db()->prepare('UPDATE posts SET slug=?,title=?,excerpt=?,body=?,image=?,author=?,is_published=?,published_at=? WHERE id=?')->execute([...$fields, $id]);
            admin_flash('Post updated.');
        } else {
            db()->prepare('INSERT INTO posts (slug,title,excerpt,body,image,author,is_published,published_at) VALUES (?,?,?,?,?,?,?,?)')->execute($fields);
            admin_flash('Post created.');
        }
    } catch (PDOException $e) {
        admin_flash('Could not save — is the slug unique? (' . e($slug) . ')', 'err');
    }
    header('Location: ' . admin_url('posts'));
    return;
}

$editing = null;
if (isset($_GET['id'])) {
    $editing = $_GET['id'] === 'new'
        ? ['id' => 0, 'slug' => '', 'title' => '', 'excerpt' => '', 'body' => '', 'image' => '', 'author' => setting('site_name', SITE_NAME), 'is_published' => 1, 'published_at' => date('Y-m-d')]
        : db()->query('SELECT * FROM posts WHERE id=' . (int) $_GET['id'])->fetch();
}

admin_head('Blog Posts');
admin_flash_render();
?>
<div class="topbar"><h2 class="page">Blog Posts</h2><?php if (!$editing): ?><a class="btn" href="<?= e(admin_url('posts?id=new')) ?>">+ New post</a><?php endif; ?></div>

<?php if ($editing): ?>
<form method="post" enctype="multipart/form-data" class="card">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= (int) $editing['id'] ?>">
  <label>Title</label><input type="text" name="title" value="<?= e($editing['title']) ?>" required>
  <label>Slug <span class="muted">(leave blank to auto-generate)</span></label><input type="text" name="slug" value="<?= e($editing['slug']) ?>">
  <label>Excerpt</label><textarea name="excerpt"><?= e($editing['excerpt']) ?></textarea>
  <label>Body <span class="muted">(HTML allowed)</span></label><textarea name="body" style="min-height:240px"><?= e($editing['body']) ?></textarea>
  <div class="row">
    <div><label>Author</label><input type="text" name="author" value="<?= e($editing['author']) ?>"></div>
    <div><label>Publish date</label><input type="text" name="published_at" value="<?= e($editing['published_at'] ? date('Y-m-d', strtotime($editing['published_at'])) : '') ?>" placeholder="YYYY-MM-DD"></div>
  </div>
  <label>Image path</label><input type="text" name="image" value="<?= e($editing['image']) ?>">
  <?php if ($editing['image']): ?><img class="thumb" src="<?= e(img($editing['image'])) ?>" style="margin-top:8px;width:140px;height:88px"><?php endif; ?>
  <label class="muted">…or upload</label><input type="file" name="image_file" accept="image/*">
  <p style="margin-top:12px"><label class="switch"><input type="checkbox" name="is_published" value="1" <?= $editing['is_published'] ? 'checked' : '' ?>> Published</label></p>
  <p><button class="btn" type="submit">Save post</button> <a class="btn sec" href="<?= e(admin_url('posts')) ?>">Cancel</a></p>
</form>
<?php else: ?>
<div class="card">
  <table>
    <tr><th></th><th>Title</th><th>Status</th><th>Date</th><th></th></tr>
    <?php foreach (db()->query('SELECT * FROM posts ORDER BY published_at DESC, id DESC') as $p): ?>
    <tr>
      <td><?php if ($p['image']): ?><img class="thumb" src="<?= e(img($p['image'])) ?>"><?php endif; ?></td>
      <td><?= e($p['title']) ?><div class="muted">/<?= e($p['slug']) ?></div></td>
      <td><?= $p['is_published'] ? '<span class="pill">published</span>' : '<span class="muted">draft</span>' ?></td>
      <td class="muted"><?= e($p['published_at'] ? date('M j, Y', strtotime($p['published_at'])) : '—') ?></td>
      <td>
        <a class="btn sm sec" href="<?= e(admin_url('posts?id=' . $p['id'])) ?>">Edit</a>
        <a class="btn sm sec" href="<?= url('blog/' . $p['slug']) ?>" target="_blank">View</a>
        <form method="post" style="display:inline" onsubmit="return confirm('Delete this post?')">
          <?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
          <button class="btn sm danger" type="submit">Del</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php endif; ?>
<?php admin_foot();
