<?php
/** Single blog post — /blog/{slug} (with BlogPosting JSON-LD). */
$post = $route_slug ? post_by_slug($route_slug) : null;
if (!$post) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}
$d = $post['published_at'] ? strtotime($post['published_at']) : null;
$seo_opts = ['title' => $post['title'], 'description' => $post['excerpt'] ?: mb_strimwidth(strip_tags($post['body']), 0, 155, '…'), 'path' => 'blog/' . $post['slug'], 'image' => $post['image'], 'type' => 'article'];
$extra_head_jsonld = blogposting_jsonld($post);
require __DIR__ . '/partials/header.php';
$page_title = $post['title'];
$crumbs = [['Home', url('')], ['Blog', url('blog')], [mb_strimwidth($post['title'], 0, 40, '…'), null]];
require __DIR__ . '/partials/breadcrumb.php';
?>
<div class="ltk-section"><div class="ltk-container">
  <article class="ltk-editable" style="max-width:820px;margin:0 auto">
    <?= edit_btn('posts?id=' . (int) $post['id'], 'Edit post') ?>
    <p class="ltk-crumb" style="color:#f2792b;font-weight:600">
      <?php if ($d): ?><?= date('F j, Y', $d) ?><?php endif; ?><?php if ($post['author']): ?> &middot; <?= e($post['author']) ?><?php endif; ?>
    </p>
    <?php if ($post['image']): ?><img src="<?= e(img($post['image'])) ?>" alt="<?= e($post['title']) ?>" style="width:100%;border-radius:12px;margin:16px 0 28px" loading="eager"><?php endif; ?>
    <div class="ltk-prose text-editor"><?= $post['body'] ?></div>
    <p style="margin-top:32px"><a class="elementskit-btn" href="<?= url('blog') ?>"><i aria-hidden="true" class="icon icon-arrow-right"></i> Back to all posts</a></p>
  </article>
</div></div>
<?php
require __DIR__ . '/sections/contact_cta.php';
require __DIR__ . '/partials/footer.php';
