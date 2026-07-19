<?php
/** Features (container 34b7221). */
$b = block('features');
?>
<div class="elementor-element elementor-element-34b7221 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=features', 'Features') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-77180351 e-con-full e-flex e-con e-child">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <?php if ($b['body']): ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>
      <?php endif; ?>
    </div>
    <div class="elementor-element elementor-element-19d10383 e-con-full e-flex e-con e-child">
      <?php if ($b['image']): ?>
      <div class="elementor-element elementor-widget elementor-widget-image animated fadeInLeft" data-widget_type="image.default">
        <div class="elementor-widget-container">
          <img loading="lazy" decoding="async" width="800" height="533" src="<?= e(img($b['image'])) ?>" class="attachment-large size-large" alt="<?= e(setting('site_name', SITE_NAME)) ?>">
        </div>
      </div>
      <?php endif; ?>
      <div class="elementor-element elementor-element-241161a3 e-con-full e-flex e-con e-child animated fadeInLeft" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
        <?php foreach (items('features') as $row): ?>
        <div class="elementor-element elementor-position-inline-start elementor-view-default elementor-mobile-position-block-start elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
          <div class="elementor-widget-container">
            <div class="elementor-icon-box-wrapper">
              <div class="elementor-icon-box-icon">
                <span class="elementor-icon"><i aria-hidden="true" class="<?= e($row['icon'] ?: 'icon icon-check') ?>"></i></span>
              </div>
              <div class="elementor-icon-box-content">
                <h4 class="elementor-icon-box-title"><span><?= $row['title'] ?></span></h4>
                <p class="elementor-icon-box-description"><?= $row['body'] ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
