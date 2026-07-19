<?php
/** Homepage team (container 5f631e94). */
$b       = block('team');
$members = items('team');
?>
<div class="elementor-element elementor-element-5f631e94 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=team', 'Team') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-1ade0690 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-8b5e76 e-flex e-con-boxed e-con e-child">
        <div class="e-con-inner">
          <?= ekit_eyebrow($b['eyebrow']) ?>
          <?= ekit_heading($b['heading'], 'center') ?>
        </div>
      </div>
    </div>

    <div class="elementor-element elementor-element-718f7bbf e-con-full e-flex e-con e-child">
      <?php foreach ($members as $i => $row): $social = $row['url'] ?: '#'; ?>
      <div class="elementor-element e-con-full e-flex e-con e-child animated fadeInUp" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_delay&quot;:<?= $i * 200 ?>}">
        <div class="elementor-element elementor-widget elementor-widget-elementskit-team" data-widget_type="elementskit-team.default">
          <div class="elementor-widget-container">
            <div class="ekit-wid-con">
              <div class="profile-image-card elementor-animation- ekit-team-img ekit-team-style-overlay text-center">
                <img decoding="async" src="<?= e(img($row['image'])) ?>" title="<?= e($row['title']) ?>" alt="<?= e($row['title']) ?>" loading="lazy">
                <div class="hover-area">
                  <div class="profile-body">
                    <h2 class="profile-title"></h2>
                    <p class="profile-designation"></p>
                  </div>
                  <div class="profile-footer">
                    <ul class="ekit-team-social-list">
                      <li><a href="<?= e($social) ?>" aria-label="Facebook"><i aria-hidden="true" class="icon icon-facebook"></i></a></li>
                      <li><a href="<?= e($social) ?>" aria-label="Twitter"><i aria-hidden="true" class="icon icon-twitter"></i></a></li>
                      <li><a href="<?= e($social) ?>" aria-label="Pinterest"><i aria-hidden="true" class="icon icon-pinterest"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="elementor-element elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
          <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
            <h4 class="elementor-icon-box-title"><span><?= $row['title'] ?></span></h4>
            <p class="elementor-icon-box-description"><?= e($row['subtitle']) ?></p>
          </div></div></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="elementor-element elementor-element-b63c942 elementor-widget__width-auto elementor-align-center elementor-widget elementor-widget-button" data-widget_type="button.default">
      <div class="elementor-widget-container"><div class="elementor-button-wrapper">
        <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('about') ?>">
          <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text">Discover All Team</span></span>
        </a>
      </div></div>
    </div>
  </div>
</div>
