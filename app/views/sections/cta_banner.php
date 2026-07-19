<?php
/** Homepage CTA banner (container 276b2e3b). */
$b     = block('cta_banner');
$label = $b['extra'] !== '' ? $b['extra'] : 'Contact Us';
$bg    = $b['image'] !== '' ? img($b['image']) : '';
$style = $bg !== '' ? ' style="background-image:url(' . "'" . e($bg) . "'" . ');"' : '';
?>
<div class="elementor-element elementor-element-276b2e3b e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"<?= $style ?>>
  <?= edit_btn('blocks?block=cta_banner', 'CTA') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-45d8f038 e-flex e-con-boxed e-con e-child">
      <div class="e-con-inner">
        <div class="elementor-element elementor-widget elementor-widget-elementskit-heading animated fadeInUp" data-widget_type="elementskit-heading.default">
          <div class="elementor-widget-container"><div class="ekit-wid-con"><div class="ekit-heading elementskit-section-title-wraper text_center   ekit_heading_tablet-   ekit_heading_mobile-">
            <h2 class="ekit-heading--title elementskit-section-title "><?= $b['heading'] ?></h2>
          </div></div></div>
        </div>
        <?php if ($b['body'] !== ''): ?>
        <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
          <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
        </div>
        <?php endif; ?>
        <div class="elementor-element elementor-widget__width-auto elementor-mobile-align-center elementor-align-center elementor-widget elementor-widget-button" data-widget_type="button.default">
          <div class="elementor-widget-container"><div class="elementor-button-wrapper">
            <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('contact') ?>">
              <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text"><?= e($label) ?></span></span>
            </a>
          </div></div>
        </div>
      </div>
    </div>
  </div>
</div>
