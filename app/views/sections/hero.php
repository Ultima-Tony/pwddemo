<?php
/** Homepage hero (container 90f95a5). */
$b     = block('hero');
$tags  = items('hero_tags');
$video = setting('hero_video_url', 'https://www.youtube.com/embed/VhBl3dHT5SY');
$imgs  = array_values(array_filter([$b['image'], $b['image2'], $b['image']]));
// pull a satisfaction-style counter for the hero stat
$stat = null;
foreach (items('counters') as $c) { if (trim($c['subtitle']) === '%') { $stat = $c; break; } }
?>
<div class="elementor-element elementor-element-90f95a5 e-flex e-con-boxed e-con e-child ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('blocks?block=hero', 'Hero') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-1180020 e-con-full e-flex e-con e-child">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>
      <div class="elementor-element elementor-element-a970a5e e-con-full e-flex e-con e-child">
        <div class="elementor-element elementor-widget elementor-widget-button" data-widget_type="button.default">
          <div class="elementor-widget-container"><div class="elementor-button-wrapper">
            <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('services') ?>">
              <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text">Our Services</span></span>
            </a>
          </div></div>
        </div>
        <?php if ($video): ?>
        <div class="elementor-element elementor-widget elementor-widget-elementskit-video" data-widget_type="elementskit-video.default">
          <div class="elementor-widget-container"><div class="ekit-wid-con"><div class="video-content">
            <a class="ekit_icon_button glow-ripple ekit-video-popup ekit-video-popup-btn" href="<?= e($video) ?>" aria-label="video-popup"><i aria-hidden="true" class="icon icon-play-button"></i></a>
          </div></div></div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="elementor-element elementor-element-202e08f e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-6fd4690 e-con-full e-flex e-con e-child">
        <div class="elementor-element elementor-element-df9e5b2 e-con-full e-flex e-con e-child animated fadeInLeft">
          <div class="elementor-element elementor-element-3ead4f1 e-con-full e-flex e-con e-child">
            <?php foreach ($imgs as $i => $src): ?>
            <div class="elementor-element elementor-widget elementor-widget-image" data-widget_type="image.default">
              <div class="elementor-widget-container"><img decoding="async" width="800" height="533" src="<?= e(img($src)) ?>" class="attachment-large size-large" alt="<?= e(setting('site_name', SITE_NAME)) ?> project" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>"></div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php if ($b['extra']): ?>
          <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
            <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
              <h4 class="elementor-icon-box-title"><span><?= e($b['extra']) ?></span></h4>
              <p class="elementor-icon-box-description">Trusted by homeowners across the prairies.</p>
            </div></div></div>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="elementor-element elementor-element-c8f5d13 e-con-full e-flex e-con e-child">
        <div class="elementor-element elementor-element-439fa67 e-con-full e-flex e-con e-child">
          <?php foreach ($tags as $t): ?>
          <div class="elementor-element elementor-widget elementor-widget-button" data-widget_type="button.default">
            <div class="elementor-widget-container"><div class="elementor-button-wrapper">
              <a class="elementor-button elementor-button-link elementor-size-sm" href="<?= url('services') ?>">
                <span class="elementor-button-content-wrapper"><span class="elementor-button-text"><?= $t['title'] ?></span></span>
              </a>
            </div></div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php if ($stat): ?>
        <div class="elementor-element elementor-element-2de0c25 e-con-full e-flex e-con e-child animated fadeInLeft">
          <div class="elementor-element elementor-widget elementor-widget-counter" data-widget_type="counter.default">
            <div class="elementor-widget-container"><div class="elementor-counter"><div class="elementor-counter-number-wrapper">
              <span class="elementor-counter-number-prefix"></span>
              <span class="elementor-counter-number" data-duration="2000" data-to-value="<?= e($stat['value']) ?>" data-from-value="0" data-delimiter=","><?= e($stat['value']) ?></span>
              <span class="elementor-counter-number-suffix"><?= e($stat['subtitle']) ?></span>
            </div></div></div>
          </div>
          <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
            <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
              <h4 class="elementor-icon-box-title"><span><?= e($stat['title']) ?></span></h4>
              <p class="elementor-icon-box-description">Our clients would recommend us to a friend.</p>
            </div></div></div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
