<?php
/** Homepage About section (container 1d971870). */
$b      = block('about');
$points = items('about_points');
?>
<div class="elementor-element elementor-element-1d971870 e-flex e-con-boxed e-con e-parent ltk-editable">
  <?= edit_btn('blocks?block=about', 'About') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-7cd364de e-con-full e-flex e-con e-child">
      <?php if ($b['image']): ?>
      <div class="elementor-element elementor-widget elementor-widget-image" data-widget_type="image.default">
        <div class="elementor-widget-container"><img decoding="async" src="<?= e(img($b['image'])) ?>" alt="<?= e(setting('site_name', SITE_NAME)) ?> renovation project" loading="lazy"></div>
      </div>
      <?php endif; ?>
      <?php if ($b['image2']): ?>
      <div class="elementor-element elementor-widget elementor-widget-image animated fadeInUp" data-widget_type="image.default">
        <div class="elementor-widget-container"><img decoding="async" src="<?= e(img($b['image2'])) ?>" alt="<?= e(setting('site_name', SITE_NAME)) ?> home improvement" loading="lazy"></div>
      </div>
      <?php endif; ?>
    </div>

    <div class="elementor-element elementor-element-5c83bc5a e-con-full e-flex e-con e-child">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>

      <div class="elementor-element elementor-element-fac443a e-con-full e-flex e-con e-child">
        <?php foreach ($points as $row): ?>
        <div class="elementor-element elementor-widget__width-inherit elementor-view-default elementor-position-block-start elementor-mobile-position-block-start elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
          <div class="elementor-widget-container">
            <div class="elementor-icon-box-wrapper">
              <div class="elementor-icon-box-icon">
                <span class="elementor-icon">
                  <svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                </span>
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

      <?php if ($b['extra']): ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><strong><?= e($b['extra']) ?></strong></p></div>
      </div>
      <?php endif; ?>

      <div class="elementor-element elementor-widget elementor-widget-button" data-widget_type="button.default">
        <div class="elementor-widget-container"><div class="elementor-button-wrapper">
          <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('about') ?>">
            <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text">Learn More</span></span>
          </a>
        </div></div>
      </div>
    </div>
  </div>
</div>
