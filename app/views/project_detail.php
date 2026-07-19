<?php
/** Single project detail — /projects/{id}/{slug}. */
$prj = $route_id ? item((int) $route_id) : null;
if (!$prj || $prj['section'] !== 'projects' || (int) $prj['is_active'] !== 1) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}
$title = strip_tags(html_entity_decode($prj['title']));
$seo_opts = ['title' => $title, 'description' => mb_strimwidth(strip_tags(html_entity_decode($prj['body'])), 0, 155, '…'), 'path' => 'projects/' . $prj['id'] . '/' . slugify($prj['title']), 'image' => $prj['image']];
require __DIR__ . '/partials/header.php';
$page_title = $prj['title'];
$crumbs = [['Home', url('')], ['Projects', url('projects')], [$title, null]];
require __DIR__ . '/partials/breadcrumb.php';
?>
<div class="ltk-section"><div class="ltk-container">
  <article class="ltk-editable" style="max-width:900px;margin:0 auto">
    <?= edit_btn('items?section=projects&id=' . (int) $prj['id'], 'Edit project') ?>
    <?php if ($prj['image']): ?><img src="<?= e(img($prj['image'])) ?>" alt="<?= e($title) ?>" style="width:100%;border-radius:12px;margin-bottom:24px" loading="eager"><?php endif; ?>
    <?php if ($prj['subtitle']): ?><span class="ltk-crumb" style="color:#f2792b;font-weight:600"><?= e($prj['subtitle']) ?></span><?php endif; ?>
    <h2 class="ekit-heading--title" style="margin:8px 0 16px"><?= $prj['title'] ?></h2>
    <div class="ltk-prose"><?= $prj['body'] ? '<p>' . nl2br($prj['body']) . '</p>' : '' ?></div>
    <p style="margin-top:24px"><a class="elementskit-btn" href="<?= url('projects') ?>"><i aria-hidden="true" class="icon icon-arrow-right"></i> Back to all projects</a></p>
  </article>
</div></div>
<?php
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
