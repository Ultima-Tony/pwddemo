<?php
/** Homepage FAQ accordion (container 4ca18a70). */
$b    = block('faq');
$faqs = items('faq');
?>
<div class="elementor-element elementor-element-4ca18a70 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=faq', 'FAQ') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-f844914 e-con-full e-flex e-con e-child">
      <?= ekit_heading($b['heading'], 'left') ?>
      <?php if ($b['body']): ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>
      <?php endif; ?>
      <div class="elementor-element elementor-element-f54003f elementor-widget__width-auto elementor-widget elementor-widget-button" data-widget_type="button.default">
        <div class="elementor-widget-container"><div class="elementor-button-wrapper">
          <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('contact') ?>">
            <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text">Help Center</span></span>
          </a>
        </div></div>
      </div>
    </div>

    <div class="elementor-element elementor-element-716322d3 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-2529ff4f elementor-widget__width-inherit elementor-widget elementor-widget-elementskit-accordion" data-widget_type="elementskit-accordion.default">
        <div class="elementor-widget-container">
          <div class="ekit-wid-con">
            <div class="elementskit-accordion accoedion-primary" id="accordion-faqhome">
              <?php foreach ($faqs as $i => $row): $first = ($i === 0); ?>
              <div class="elementskit-card <?= $first ? 'active' : '' ?>">
                <div class="elementskit-card-header" id="primaryHeading-<?= $i ?>-faqhome">
                  <a href="#ltk-collapse-home-<?= $i ?>" class="ekit-accordion--toggler elementskit-btn-link collapsed" data-ekit-toggle="collapse" data-target="#ltk-collapse-home-<?= $i ?>" aria-expanded="<?= $first ? 'true' : 'false' ?>" aria-controls="ltk-collapse-home-<?= $i ?>">
                    <span class="ekit-accordion-title"><?= $row['title'] ?></span>
                    <div class="ekit_accordion_icon_group">
                      <div class="ekit_accordion_normal_icon"><i class="icon icon-down-arrow1"></i></div>
                      <div class="ekit_accordion_active_icon"><i class="icon icon-up-arrow"></i></div>
                    </div>
                  </a>
                </div>
                <div id="ltk-collapse-home-<?= $i ?>" class="<?= $first ? ' show collapse' : ' collapse' ?>" aria-labelledby="primaryHeading-<?= $i ?>-faqhome" data-parent="#accordion-faqhome">
                  <div class="elementskit-card-body ekit-accordion--content">
                    <p><?= $row['body'] ?></p>
                  </div>
                </div>
              </div><!-- .elementskit-card END -->
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
