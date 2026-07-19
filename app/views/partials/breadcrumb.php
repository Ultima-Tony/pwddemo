<?php
/**
 * Inner-page hero + breadcrumb. Set BEFORE requiring:
 *   $page_title (string), $crumbs (array of [label, url] pairs; last has null url).
 */
$page_title = $page_title ?? '';
$crumbs     = $crumbs ?? [['Home', url('')]];
?>
<div class="ltk-page-hero">
  <div class="ltk-container">
    <h1><?= $page_title ?></h1>
    <nav class="ltk-crumb" aria-label="Breadcrumb">
      <?php foreach ($crumbs as $i => $c): ?>
        <?php if (!empty($c[1])): ?><a href="<?= e($c[1]) ?>"><?= e($c[0]) ?></a><?php else: ?><span><?= e($c[0]) ?></span><?php endif; ?>
        <?php if ($i < count($crumbs) - 1): ?> <span aria-hidden="true">/</span> <?php endif; ?>
      <?php endforeach; ?>
    </nav>
  </div>
</div>
