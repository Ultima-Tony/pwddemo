<?php
/** Site footer partial (elementor-1679) + scripts. Closes #content, body, html. */
$biz     = setting('site_name', SITE_NAME);
$logoD   = img(setting('logo', 'assets/img/logo.svg'), 'assets/img/logo.svg');
$email   = setting('contact_email', SITE_EMAIL);
$phone   = setting('contact_phone', '');
$addr    = trim(setting('contact_address', '') . ', ' . setting('contact_city', '') . ' ' . setting('contact_region', ''), ', ');
$fabout  = setting('footer_about', '');
$note    = setting('footer_note', 'All rights reserved.');
$socials = array_filter([
  'facebook'  => setting('social_facebook', ''),
  'twitter'   => setting('social_twitter', ''),
  'instagram' => setting('social_instagram', ''),
  'linkedin'  => setting('social_linkedin', ''),
]);
$quick = [
  ['Home', url('')], ['About Us', url('about')], ['Our Services', url('services')],
  ['Our Projects', url('projects')], ['Contact Us', url('contact')],
];
$useful = [
  ['Our Pricing', url('pricing')], ['Our Team', url('team')], ['FAQs', url('faqs')],
  ['Testimonials', url('testimonials')], ['Blog', url('blog')],
];
?>
</div><!-- /#content -->

<!-- ============================ FOOTER (elementor-1679) ============================ -->
<div class="ekit-template-content-markup ekit-template-content-footer ekit-template-content-theme-support">
  <div data-elementor-type="wp-post" data-elementor-id="1679" class="elementor elementor-1679">
    <div class="elementor-element elementor-element-cdb479e e-flex e-con-boxed e-con e-parent">
      <div class="e-con-inner">
        <div class="elementor-element elementor-element-df1314e e-con-full e-flex e-con e-child">

          <!-- Col 1: brand + contact -->
          <div class="elementor-element elementor-element-7f57b6d e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-element-128b856 elementor-widget elementor-widget-image" data-widget_type="image.default">
              <div class="elementor-widget-container"><img src="<?= e($logoD) ?>" alt="<?= e($biz) ?>" decoding="async"></div>
            </div>
            <div class="elementor-element elementor-element-e5df851 elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
              <div class="elementor-widget-container"><p><?= e($fabout) ?></p></div>
            </div>
            <div class="elementor-element elementor-element-1ce3c5d elementor-widget elementor-widget-icon-list" data-widget_type="icon-list.default">
              <div class="elementor-widget-container">
                <ul class="elementor-icon-list-items">
                  <?php if ($email): ?><li class="elementor-icon-list-item"><a href="mailto:<?= e($email) ?>"><span class="elementor-icon-list-icon"><i aria-hidden="true" class="icon icon-email1"></i></span><span class="elementor-icon-list-text"><?= e($email) ?></span></a></li><?php endif; ?>
                  <?php if ($phone): ?><li class="elementor-icon-list-item"><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"><span class="elementor-icon-list-icon"><i aria-hidden="true" class="icon icon-phone1"></i></span><span class="elementor-icon-list-text"><?= e($phone) ?></span></a></li><?php endif; ?>
                  <?php if ($addr): ?><li class="elementor-icon-list-item"><span class="elementor-icon-list-icon"><i aria-hidden="true" class="icon icon-location"></i></span><span class="elementor-icon-list-text"><?= e($addr) ?></span></li><?php endif; ?>
                </ul>
              </div>
            </div>
          </div>

          <!-- Col 2: Quick Links -->
          <div class="elementor-element elementor-element-780bad0 e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-element-b86aafb elementor-widget elementor-widget-heading" data-widget_type="heading.default">
              <div class="elementor-widget-container"><h4 class="elementor-heading-title elementor-size-default">Quick Links</h4></div>
            </div>
            <div class="elementor-element elementor-element-fc327a7 elementor-widget elementor-widget-icon-list" data-widget_type="icon-list.default">
              <div class="elementor-widget-container"><ul class="elementor-icon-list-items">
                <?php foreach ($quick as $l): ?><li class="elementor-icon-list-item"><a href="<?= e($l[1]) ?>"><span class="elementor-icon-list-text"><?= e($l[0]) ?></span></a></li><?php endforeach; ?>
              </ul></div>
            </div>
          </div>

          <!-- Col 3: Useful Links -->
          <div class="elementor-element elementor-element-bd8be1f e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-element-8b3d979 elementor-widget elementor-widget-heading" data-widget_type="heading.default">
              <div class="elementor-widget-container"><h4 class="elementor-heading-title elementor-size-default">Useful Links</h4></div>
            </div>
            <div class="elementor-element elementor-element-4cdc22f elementor-widget elementor-widget-icon-list" data-widget_type="icon-list.default">
              <div class="elementor-widget-container"><ul class="elementor-icon-list-items">
                <?php foreach ($useful as $l): ?><li class="elementor-icon-list-item"><a href="<?= e($l[1]) ?>"><span class="elementor-icon-list-text"><?= e($l[0]) ?></span></a></li><?php endforeach; ?>
              </ul></div>
            </div>
          </div>

          <!-- Col 4: newsletter + social -->
          <div class="elementor-element elementor-element-6aa7115 e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-element-42f6a8c elementor-widget elementor-widget-icon-box" data-widget_type="icon-box.default">
              <div class="elementor-widget-container"><div class="elementor-icon-box-wrapper"><div class="elementor-icon-box-content">
                <h5 class="elementor-icon-box-title"><span>Subscribe Our Newsletter</span></h5>
                <p class="elementor-icon-box-description">Get our latest updates, tips and project stories.</p>
              </div></div></div>
            </div>
            <form class="ltk-newsletter" method="post" action="<?= url('contact') ?>">
              <input type="email" name="newsletter_email" placeholder="Your email address" aria-label="Email">
              <button type="submit" class="elementskit-btn">Subscribe</button>
            </form>
            <?php if ($socials): ?>
            <div class="elementor-element elementor-element-be66f47 elementor-shape-circle e-grid-align-left elementor-widget elementor-widget-social-icons" data-widget_type="social-icons.default">
              <div class="elementor-widget-container">
                <div class="elementor-social-icons-wrapper elementor-grid" role="list">
                  <?php foreach ($socials as $net => $u): ?>
                  <span class="elementor-grid-item" role="listitem"><a class="elementor-icon elementor-social-icon elementor-social-icon-<?= e($net) ?>" href="<?= e($u) ?>" target="_blank" rel="noopener"><span class="elementor-screen-only"><?= e(ucfirst($net)) ?></span><i class="icon icon-<?= e($net) ?>"></i></a></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>

        </div>
        <!-- bottom bar -->
        <div class="elementor-element elementor-element-7d350a0 e-con-full e-flex e-con e-child">
          <div class="elementor-element elementor-element-d506a28 elementor-widget elementor-widget-heading" data-widget_type="heading.default">
            <div class="elementor-widget-container"><span class="elementor-heading-title elementor-size-default">&copy; <?= date('Y') ?> <?= e($biz) ?> &mdash; <?= e($note) ?></span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/site.js"></script>
</body>
</html>
