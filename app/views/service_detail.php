<?php
/** Single service detail — /services/{id}/{slug}. */
$svc = $route_id ? item((int) $route_id) : null;
if (!$svc || $svc['section'] !== 'services' || (int) $svc['is_active'] !== 1) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    return;
}
$all = items('services');
$title = strip_tags(html_entity_decode($svc['title']));
$seo_opts = ['title' => $title, 'description' => mb_strimwidth(strip_tags(html_entity_decode($svc['body'])), 0, 155, '…'), 'path' => 'services/' . $svc['id'] . '/' . slugify($svc['title']), 'image' => $svc['image']];
require __DIR__ . '/partials/header.php';
$page_title = $svc['title'];
$crumbs = [['Home', url('')], ['Services', url('services')], [$title, null]];
require __DIR__ . '/partials/breadcrumb.php';
?>
<div class="ltk-section"><div class="ltk-container">
  <div class="ltk-grid" style="grid-template-columns:minmax(0,2fr) minmax(0,1fr);align-items:start">
    <article class="ltk-editable">
      <?= edit_btn('items?section=services&id=' . (int) $svc['id'], 'Edit service') ?>
      <?php if ($svc['image']): ?><img src="<?= e(img($svc['image'])) ?>" alt="<?= e($title) ?>" style="width:100%;border-radius:12px;margin-bottom:24px" loading="eager"><?php endif; ?>
      <?php if ($svc['subtitle']): ?><span class="ltk-crumb" style="color:#f2792b;font-weight:600"><?= e($svc['subtitle']) ?></span><?php endif; ?>
      <h2 class="ekit-heading--title" style="margin:8px 0 16px"><?= $svc['title'] ?></h2>
      <div class="ltk-prose"><?= $svc['body'] ? '<p>' . nl2br($svc['body']) . '</p>' : '' ?></div>
      <p style="margin-top:24px"><a class="elementskit-btn" href="<?= url('contact') ?>#quote">Request a Quote <i aria-hidden="true" class="icon icon-arrow-right"></i></a></p>
    </article>
    <aside>
      <div class="elementskit-single-pricing" style="padding:24px">
        <h4 class="elementskit-pricing-title" style="margin-bottom:14px">All Services</h4>
        <ul class="elementskit-pricing-lists" style="list-style:none;padding:0;margin:0">
          <?php foreach ($all as $s): $lnk = url('services/' . $s['id'] . '/' . slugify($s['title'])); ?>
          <li style="padding:8px 0;border-bottom:1px solid #eee"><a href="<?= e($lnk) ?>"<?= (int) $s['id'] === (int) $svc['id'] ? ' style="color:#f2792b;font-weight:600"' : '' ?>><i aria-hidden="true" class="icon icon-arrow-right"></i> <?= $s['title'] ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </aside>
  </div>
</div></div>
<?php
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
