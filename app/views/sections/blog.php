<?php
/** Homepage blog (container 66bcd503). */
$b     = block('blog');
$posts = posts(3);
?>
<div class="elementor-element elementor-element-66bcd503 e-flex e-con-boxed e-con e-parent ltk-editable" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('posts', 'Blog posts') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-6fb39083 e-con-full e-flex e-con e-child">
      <div class="elementor-element elementor-element-62da5f0b e-flex e-con-boxed e-con e-child">
        <div class="e-con-inner">
          <?= ekit_eyebrow($b['eyebrow']) ?>
          <?= ekit_heading($b['heading'], 'center') ?>
        </div>
      </div>
    </div>

    <div class="elementor-element elementor-element-f583c51 ekit-blog-posts--bg-hover bg-hover-classic elementor-widget elementor-widget-elementskit-blog-posts" data-widget_type="elementskit-blog-posts.default">
      <div class="elementor-widget-container">
        <div class="ekit-wid-con">
          <div class="row post-items">
            <?php foreach ($posts as $post): $link = url('blog/' . $post['slug']); ?>
            <div class="col-lg-4 col-md-6">
              <div class="elementskit-post-image-card">
                <div class="elementskit-entry-header">
                  <a href="<?= e($link) ?>" class="elementskit-entry-thumb">
                    <img decoding="async" loading="lazy" src="<?= e(img($post['image'])) ?>" alt="<?= e($post['title']) ?>">
                  </a>
                  <div class="elementskit-meta-lists elementskit-style-tag">
                    <div class="elementskit-single-meta triangle_left"><span class="elementskit-meta-wraper"><strong><?= e(date('j', strtotime($post['published_at']))) ?></strong><?= e(date('M', strtotime($post['published_at']))) ?></span></div>
                  </div>
                  <div class="elementskit-meta-categories">
                    <span class="elementskit-meta-wraper">
                      <span><a href="<?= e($link) ?>" rel="category tag"><?= e($post['author'] ?: 'Insights') ?></a></span>
                    </span>
                  </div>
                </div>
                <div class="elementskit-post-body ">
                  <h2 class="entry-title">
                    <a href="<?= e($link) ?>"><?= e($post['title']) ?></a>
                  </h2>
                  <p><?= e($post['excerpt']) ?></p>
                  <div class="btn-wraper">
                    <a class="elementskit-btn whitespace--normal" href="<?= e($link) ?>">Read More <i aria-hidden="true" class="icon icon-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="elementor-element elementor-element-33d22912 elementor-align-center elementor-widget elementor-widget-button" data-widget_type="button.default">
      <div class="elementor-widget-container"><div class="elementor-button-wrapper">
        <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('blog') ?>">
          <span class="elementor-button-content-wrapper"><span class="elementor-button-icon"><i aria-hidden="true" class="icon icon-arrow-right"></i></span><span class="elementor-button-text">Discover Blog</span></span>
        </a>
      </div></div>
    </div>
  </div>
</div>
