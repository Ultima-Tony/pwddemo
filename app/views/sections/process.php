<?php
/** Process steps (container 4b89d172). */
$b     = block('process');
$steps = items('process');
?>
<div class="elementor-element elementor-element-4b89d172 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=process', 'Process') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-2ffdea1f e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-1d368dd3 e-con-full e-flex e-con e-child">
        <?= ekit_eyebrow($b['eyebrow']) ?>
        <?= ekit_heading($b['heading'], 'left') ?>
      </div>
      <?php if ($b['body']): ?>
      <div class="elementor-element elementor-element-6b78e836 e-con-full e-flex e-con e-child">
        <div class="elementor-element elementor-widget__width-inherit elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
          <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="elementor-element elementor-element-541ecc30 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-228dfaf1 e-con-full e-flex e-con e-child">
        <?php foreach ($steps as $row): ?>
        <div class="elementor-element e-con-full e-flex e-con e-child">
          <div class="elementor-element e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-widget elementor-widget-heading" data-widget_type="heading.default">
              <div class="elementor-widget-container">
                <h4 class="elementor-heading-title elementor-size-default"><?= e($row['value']) ?></h4>
              </div>
            </div>
            <div class="elementor-element elementor-widget__width-initial elementor-widget elementor-widget-spacer" data-widget_type="spacer.default">
              <div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div>
            </div>
          </div>
          <div class="elementor-element e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
              <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
                <h4 class="elementor-icon-box-title"><span><?= $row['title'] ?></span></h4>
                <p class="elementor-icon-box-description"><?= $row['body'] ?></p>
              </div></div></div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
