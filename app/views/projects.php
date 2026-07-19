<?php
/** Our Projects — gallery grid of items('projects'). */
$projects = items('projects');
$seo_opts = ['title' => 'Our Projects', 'description' => 'Recent contracting and renovation projects by ' . setting('site_name', SITE_NAME) . '.', 'path' => 'projects'];
require __DIR__ . '/partials/header.php';
$page_title = 'Our Projects';
$crumbs = [['Home', url('')], ['Projects', null]];
require __DIR__ . '/partials/breadcrumb.php';
?>
<div class="elementor-element e-flex e-con-boxed e-con e-parent ltk-editable">
  <?= edit_btn('items?section=projects', 'Projects') ?>
  <div class="e-con-inner">
    <div class="ekit-wid-con"><div class="row post-items">
      <?php foreach ($projects as $p): $link = url('projects/' . $p['id'] . '/' . slugify($p['title'])); ?>
      <div class="col-lg-4 col-md-6">
        <div class="elementskit-post-image-card">
          <div class="elementskit-entry-header">
            <a href="<?= e($link) ?>" class="elementskit-entry-thumb"><img decoding="async" src="<?= e(img($p['image'])) ?>" alt="<?= e(strip_tags($p['title'])) ?>" loading="lazy"></a>
            <?php if ($p['subtitle']): ?><div class="elementskit-meta-categories"><span class="elementskit-meta-wraper"><span><a href="<?= e($link) ?>" rel="category tag"><?= e($p['subtitle']) ?></a></span></span></div><?php endif; ?>
          </div>
          <div class="elementskit-post-body ">
            <h2 class="entry-title"><a href="<?= e($link) ?>"><?= $p['title'] ?></a></h2>
            <p><?= e(mb_strimwidth(strip_tags(html_entity_decode($p['body'])), 0, 120, '…')) ?></p>
            <div class="btn-wraper"><a class="elementskit-btn whitespace--normal" href="<?= e($link) ?>">View Project <i aria-hidden="true" class="icon icon-arrow-right"></i></a></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div></div>
  </div>
</div>
<?php
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
