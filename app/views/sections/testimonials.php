<?php
/** Testimonials slider (container a694155). */
$b     = block('testimonials');
$rows  = items('testimonials');
$imgs  = array_values(array_filter([$b['image2'], $b['extra']]));
$star  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288 0s-23.6 7-28.9 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L470.7 329 574.9 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L413.1 150.3 348.4 18z"></path></svg>';
?>
<div class="elementor-element elementor-element-a694155 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('items?section=testimonials', 'Testimonials') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-68de3393 e-con-full e-flex e-con e-child">
      <?php if ($b['image']): ?>
      <div class="elementor-element elementor-widget elementor-widget-image" data-widget_type="image.default">
        <div class="elementor-widget-container"><img decoding="async" src="<?= e(img($b['image'])) ?>" alt="<?= e(setting('site_name', SITE_NAME)) ?> testimonials" loading="lazy"></div>
      </div>
      <?php endif; ?>
      <?php if ($imgs): ?>
      <div class="elementor-element elementor-element-7c3d1e0f e-flex e-con-boxed e-con e-child">
        <div class="e-con-inner">
          <?php foreach ($imgs as $src): ?>
          <div class="elementor-element elementor-widget__width-inherit elementor-widget elementor-widget-image" data-widget_type="image.default">
            <div class="elementor-widget-container"><img decoding="async" src="<?= e(img($src)) ?>" alt="<?= e(setting('site_name', SITE_NAME)) ?> project" loading="lazy"></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="elementor-element elementor-element-38b08f15 e-con-full e-flex e-con e-child">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <?php if ($b['body']): ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>
      <?php endif; ?>
      <div class="elementor-element elementor-element-265a394 ekit-testimonial-slide elementor-widget elementor-widget-elementskit-testimonial e-widget-swiper" data-widget_type="elementskit-testimonial.default">
        <div class="elementor-widget-container">
          <div class="ekit-wid-con">
            <div class="elementskit-testimonial-slider ekit_testimonial_style_5 arrow_inside " data-config="{&quot;rtl&quot;:false,&quot;arrows&quot;:false,&quot;dots&quot;:false,&quot;pauseOnHover&quot;:true,&quot;autoplay&quot;:true,&quot;speed&quot;:1000,&quot;slidesPerGroup&quot;:1,&quot;slidesPerView&quot;:1,&quot;loop&quot;:true,&quot;spaceBetween&quot;:30,&quot;breakpoints&quot;:{&quot;320&quot;:{&quot;slidesPerView&quot;:1,&quot;slidesPerGroup&quot;:1,&quot;spaceBetween&quot;:10},&quot;768&quot;:{&quot;slidesPerView&quot;:2,&quot;slidesPerGroup&quot;:1,&quot;spaceBetween&quot;:30},&quot;1024&quot;:{&quot;slidesPerView&quot;:1,&quot;slidesPerGroup&quot;:1,&quot;spaceBetween&quot;:30}}}">
              <div class="ekit-main-swiper swiper">
                <div class="swiper-wrapper">
                  <?php foreach ($rows as $row): $stars = max(0, (int) $row['value']); ?>
                  <div class="swiper-slide" role="group">
                    <div class="swiper-slide-inner">
                      <div class="elementskit-single-testimonial-slider elementskit-testimonial-slider-block-style elementskit-testimonial-slider-block-style-two ">
                        <div class="elementskit-commentor-header">
                          <ul class="elementskit-stars">
                            <?php for ($s = 0; $s < $stars; $s++): ?>
                            <li><a><?= $star ?></a></li>
                            <?php endfor; ?>
                          </ul>
                        </div>
                        <div class="elementskit-commentor-content"><p><?= $row['body'] ?></p></div>
                        <div class="elementskit-commentor-bio">
                          <div class="elementkit-commentor-details ">
                            <?php if ($row['image']): ?>
                            <div class="elementskit-commentor-image ekit-testimonial--avatar">
                              <img loading="lazy" decoding="async" src="<?= e(img($row['image'])) ?>" class="attachment-full size-full" alt="<?= e($row['title']) ?>">
                            </div>
                            <?php endif; ?>
                            <div class="elementskit-profile-info">
                              <strong class="elementskit-author-name"><?= $row['title'] ?></strong>
                              <span class="elementskit-author-des"><?= e($row['subtitle']) ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
