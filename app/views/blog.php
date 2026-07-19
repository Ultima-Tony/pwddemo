<?php
/** Blog listing — all published posts. */
$all = posts();
$seo_opts = ['title' => 'Blog', 'description' => 'Renovation tips, guides and news from ' . setting('site_name', SITE_NAME) . '.', 'path' => 'blog'];
require __DIR__ . '/partials/header.php';
$page_title = 'Our Blog';
$crumbs = [['Home', url('')], ['Blog', null]];
require __DIR__ . '/partials/breadcrumb.php';
?>
<div class="ltk-section"><div class="ltk-container ltk-editable">
  <?= edit_btn('posts', 'Blog posts') ?>
  <div class="ekit-wid-con"><div class="row post-items">
    <?php if (!$all): ?><p>No posts yet — check back soon.</p><?php endif; ?>
    <?php foreach ($all as $post): $link = url('blog/' . $post['slug']); $d = $post['published_at'] ? strtotime($post['published_at']) : null; ?>
    <div class="col-lg-4 col-md-6">
      <div class="elementskit-post-image-card">
        <div class="elementskit-entry-header">
          <a href="<?= e($link) ?>" class="elementskit-entry-thumb"><img decoding="async" src="<?= e(img($post['image'])) ?>" alt="<?= e($post['title']) ?>" loading="lazy"></a>
          <?php if ($d): ?><div class="elementskit-meta-lists elementskit-style-tag"><div class="elementskit-single-meta triangle_left"><span class="elementskit-meta-wraper"><strong><?= date('j', $d) ?></strong><?= date('M', $d) ?></span></div></div><?php endif; ?>
          <?php if ($post['author']): ?><div class="elementskit-meta-categories"><span class="elementskit-meta-wraper"><span><?= e($post['author']) ?></span></span></div><?php endif; ?>
        </div>
        <div class="elementskit-post-body ">
          <h2 class="entry-title"><a href="<?= e($link) ?>"><?= e($post['title']) ?></a></h2>
          <p><?= e($post['excerpt']) ?></p>
          <div class="btn-wraper"><a class="elementskit-btn whitespace--normal" href="<?= e($link) ?>">Read More <i aria-hidden="true" class="icon icon-arrow-right"></i></a></div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div></div>
</div></div>
<?php require __DIR__ . '/partials/footer.php'; ?>
