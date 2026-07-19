<?php
/** Why-Choose-Us (container 70aa561b). */
$b = block('why_choose');
?>
<div class="elementor-element elementor-element-70aa561b e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=why_choose', 'Why Choose Us') ?>
  <div class="e-con-inner">
    <?php if ($b['image']): ?>
    <div class="elementor-element elementor-element-11454317 e-con-full e-flex e-con e-child" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
      <div class="elementor-element elementor-widget elementor-widget-image animated fadeInLeft" data-widget_type="image.default">
        <div class="elementor-widget-container">
          <img loading="lazy" decoding="async" width="800" height="422" src="<?= e(img($b['image'])) ?>" class="attachment-large size-large" alt="<?= e(setting('site_name', SITE_NAME)) ?>">
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div class="elementor-element elementor-element-64123ab9 e-con-full e-flex e-con e-child">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <?php if ($b['body']): ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>
      <?php endif; ?>
      <div class="elementor-element elementor-element-6d3e4a1b e-con-full e-flex e-con e-child">
        <?php if ($b['image2']): ?>
        <div class="elementor-element elementor-widget elementor-widget-image animated fadeInLeft" data-widget_type="image.default">
          <div class="elementor-widget-container">
            <img loading="lazy" decoding="async" width="800" height="422" src="<?= e(img($b['image2'])) ?>" class="attachment-large size-large" alt="<?= e(setting('site_name', SITE_NAME)) ?>">
          </div>
        </div>
        <?php endif; ?>
        <div class="elementor-element elementor-element-78940fcb e-con-full e-flex e-con e-child" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
          <?php if ($b['extra']): ?>
          <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
            <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
              <h4 class="elementor-icon-box-title"><span><?= e($b['extra']) ?></span></h4>
            </div></div></div>
          </div>
          <?php endif; ?>
          <div class="elementor-element elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-widget_type="icon-list.default">
            <div class="elementor-widget-container">
              <ul class="elementor-icon-list-items">
                <?php foreach (items('why_choose') as $row): ?>
                <li class="elementor-icon-list-item">
                  <span class="elementor-icon-list-icon"><i aria-hidden="true" class="<?= e($row['icon'] ?: 'icon icon-check') ?>"></i></span>
                  <span class="elementor-icon-list-text"><?= $row['title'] ?></span>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
