<?php
/** Services grid (container 3273ef56). */
$b = block('services');
?>
<div class="elementor-element elementor-element-3273ef56 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=services', 'Services') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-62698c66 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-7c1daf28 e-flex e-con-boxed e-con e-child">
        <div class="e-con-inner">
          <?= ekit_eyebrow($b['eyebrow']) ?>
          <?= ekit_heading($b['heading'], 'center') ?>
        </div>
      </div>
    </div>
    <div class="elementor-element elementor-element-19a9e092 e-con-full e-flex e-con e-child">
      <?php foreach (items('services') as $row): ?>
      <div class="elementor-element e-con-full e-flex e-con e-child animated fadeInUp">
        <div class="elementor-element elementor-widget elementor-widget-elementskit-icon-box" data-widget_type="elementskit-icon-box.default">
          <div class="elementor-widget-container">
            <div class="ekit-wid-con">
              <div class="elementskit-infobox text-center text-center icon-top-align elementor-animation-  gradient-active image-active ">
                <div class="elementskit-box-header elementor-animation-">
                  <div class="elementskit-info-box-icon  ">
                    <i aria-hidden="true" class="elementkit-infobox-icon <?= e($row['icon']) ?>"></i>
                  </div>
                </div>
                <div class="box-body">
                  <h3 class="elementskit-info-box-title"><?= $row['title'] ?></h3>
                  <p><?= $row['body'] ?></p>
                  <div class="box-footer disable_hover_button">
                    <div class="btn-wraper">
                      <a class="elementskit-btn whitespace--normal elementor-animation-float" href="<?= url('services/' . $row['id'] . '/' . slugify($row['title'])) ?>">Learn more <i aria-hidden="true" class="icon icon-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
