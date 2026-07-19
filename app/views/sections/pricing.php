<?php
/** Pricing (container 525d2512). */
$b          = block('pricing');
$plans      = items('pricing');
$show_price = setting_on('show_prices');
?>
<div class="elementor-element elementor-element-525d2512 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=pricing', 'Pricing') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-431faba4 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-2397de79 e-flex e-con-boxed e-con e-child">
        <div class="e-con-inner">
          <?= ekit_eyebrow($b['eyebrow']) ?>
          <?= ekit_heading($b['heading'], 'center') ?>
        </div>
      </div>
    </div>

    <div class="elementor-element elementor-element-2d6c982d e-con-full e-flex e-con e-child">
      <?php foreach ($plans as $row): ?>
      <?php
        $popular  = trim((string) $row['icon']) === 'popular';
        $numeric  = is_numeric(str_replace([',', ' '], '', (string) $row['value']));
        $features = array_filter(array_map('trim', explode("\n", (string) $row['body'])), 'strlen');
      ?>
      <div class="elementor-element e-con-full e-flex e-con e-child<?= $popular ? ' ekit-pricing-popular' : '' ?>">
        <?php if ($popular): ?>
        <div class="elementor-element elementor-widget__width-auto elementor-absolute elementor-widget elementor-widget-heading" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="heading.default">
          <div class="elementor-widget-container">
            <span class="elementor-heading-title elementor-size-default">Most Popular</span>
          </div>
        </div>
        <?php endif; ?>
        <div class="elementor-element elementor-widget elementor-widget-elementskit-pricing" data-widget_type="elementskit-pricing.default">
          <div class="elementor-widget-container">
            <div class="ekit-wid-con">
              <div class="elementskit-single-pricing <?= $popular ? 'ekit-pricing-highlight' : '' ?>">
                <div class="elementskit-pricing-header ">
                  <h3 class=" elementskit-pricing-title"><?= $row['title'] ?></h3>
                  <?php if ($row['subtitle']): ?>
                  <p class=" elementskit-pricing-subtitle"><?= e($row['subtitle']) ?></p>
                  <?php endif; ?>
                </div>
                <?php if ($show_price && $row['value'] !== ''): ?>
                <div class=" elementskit-pricing-price-wraper has-tag ">
                  <div class="elementskit-pricing-tag"></div>
                  <span class="elementskit-pricing-price">
                    <?php if ($numeric): ?>
                    <sup class="currency">$</sup>
                    <span><?= e($row['value']) ?></span>
                    <?php if ($row['subtitle']): ?><sub class="period">/ <?= e($row['subtitle']) ?></sub><?php endif; ?>
                    <?php else: ?>
                    <span><?= e($row['value']) ?></span>
                    <?php endif; ?>
                  </span>
                </div>
                <?php endif; ?>
                <div class="elementskit-pricing-content ">
                  <ul class="elementskit-pricing-lists">
                    <?php foreach ($features as $feature): ?>
                    <li><i aria-hidden="true" class="icon icon-check"></i> <?= $feature ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div class="elementskit-pricing-btn-wraper ">
                  <a href="<?= url('contact') ?>" class="elementskit-pricing-btn  ekit-pricing-btn-icon-pos-right">Get a Quote<i aria-hidden="true" class="icon icon-arrow-right"></i></a>
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
