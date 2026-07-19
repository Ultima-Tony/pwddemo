<?php
/** Homepage Counters / stats strip (container 40bb28c5). Titleless. */
$stats  = items('counters');
$delays = [0, 200, 400, 600];
?>
<div class="elementor-element elementor-element-40bb28c5 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=counters', 'Stats') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-42542c89 e-con-full e-flex e-con e-child">
      <?php foreach ($stats as $i => $row): $delay = $delays[$i % 4]; ?>
      <div class="elementor-element e-flex e-con-boxed e-con e-child animated fadeInUp" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_delay&quot;:<?= (int) $delay ?>}">
        <div class="e-con-inner">
          <div class="elementor-element elementor-widget elementor-widget-counter" data-widget_type="counter.default">
            <div class="elementor-widget-container"><div class="elementor-counter"><div class="elementor-counter-number-wrapper">
              <span class="elementor-counter-number-prefix"></span>
              <span class="elementor-counter-number" data-duration="2000" data-to-value="<?= e($row['value']) ?>" data-from-value="0" data-delimiter=","><?= e($row['value']) ?></span>
              <span class="elementor-counter-number-suffix"></span>
            </div></div></div>
          </div>
          <?php if ($row['subtitle'] !== ''): ?>
          <div class="elementor-element elementor-widget__width-auto elementor-widget elementor-widget-heading" data-widget_type="heading.default">
            <div class="elementor-widget-container"><h6 class="elementor-heading-title elementor-size-default"><?= e($row['subtitle']) ?></h6></div>
          </div>
          <?php endif; ?>
          <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
            <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
              <h4 class="elementor-icon-box-title"><span><?= $row['title'] ?></span></h4>
              <?php if (!empty($row['body'])): ?><p class="elementor-icon-box-description"><?= $row['body'] ?></p><?php endif; ?>
            </div></div></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
