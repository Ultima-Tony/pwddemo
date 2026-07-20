<?php
/**
 * Site header partial. A view sets $seo_opts (array) and optionally
 * $extra_head_jsonld (string) BEFORE requiring this file.
 *
 *   $seo_opts = ['title'=>..., 'description'=>..., 'path'=>..., 'image'=>...];
 */
$seo_opts          = $seo_opts          ?? [];
$extra_head_jsonld = $extra_head_jsonld ?? '';
$body_class        = $body_class        ?? '';

// Which top-level nav item is active (by first path segment).
$cur = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
$seg0 = explode('/', $cur)[0] ?? '';
$is = fn(string $p): string => ($seg0 === $p || ($p === '' && $seg0 === '')) ? ' active' : '';

$logo = img(setting('logo', 'assets/img/logo.svg'), 'assets/img/logo.svg');
$biz  = setting('site_name', SITE_NAME);

// Stylesheet list (kept faithful to the template so its per-element CSS applies).
$css = [
  'frontend.min.css','post-1674.css','post-1679.css','all.min.css','v4-shims.min.css',
  'template-kit-export-public.css','style.css','text-editor.css','reset.css','theme.css',
  'header-footer.css','post-8.css','fadeInUp.min.css','e-animation-float.min.css',
  'mediaelementplayer-legacy.min.css','wp-mediaelement.min.css','widget-image.min.css',
  'widget-icon-box.min.css','fadeInLeft.min.css','widget-counter.min.css','widget-icon-list.min.css',
  'widget-heading.min.css','swiper.min.css','widget-spacer.min.css','post-1232.css',
  'widget-styles.css','responsive.css','manrope.css','ekiticons.css','metform-ui.css',
  'widget-social-icons.min.css','apple-webkit.min.css','post-1634.css','site.v2.css',
];
?><!DOCTYPE html>
<html lang="en-CA">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="/">
<?= seo_tags($seo_opts) ?>
<?php foreach ($css as $f): ?>
<link rel="stylesheet" href="assets/css/<?= e($f) ?>">
<?php endforeach; ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-migrate.min.js"></script>
<?= localbusiness_jsonld() ?>
<?= $extra_head_jsonld ?>
</head>
<body class="home wp-singular page-template-elementor_header_footer wp-theme-hello-elementor hello-elementor-default elementor-default elementor-template-full-width elementor-kit-8 elementor-page e--ua-blink e--ua-chrome e--ua-webkit <?= e($body_class) ?>" data-elementor-device-mode="desktop">

<a class="skip-link screen-reader-text" href="#content">Skip to content</a>

<?= admin_bar() ?>

<!-- ============================ HEADER (elementor-1674) ============================ -->
<div class="ekit-template-content-markup ekit-template-content-header ekit-template-content-theme-support">
  <div data-elementor-type="wp-post" data-elementor-id="1674" class="elementor elementor-1674">
    <div class="elementor-element elementor-element-f3ad92a e-flex e-con-boxed e-con e-child">
      <div class="e-con-inner">
        <div class="elementor-element elementor-element-66e743f e-con-full e-flex e-con e-child">
          <div class="elementor-element elementor-element-443963a e-con-full e-flex e-con e-child">

            <!-- Logo -->
            <div class="elementor-element elementor-element-a342e30 elementor-widget__width-initial elementor-widget elementor-widget-image" data-widget_type="image.default">
              <div class="elementor-widget-container">
                <a href="<?= url('') ?>"><img fetchpriority="high" src="<?= e($logo) ?>" alt="<?= e($biz) ?>" width="443" height="130" class="attachment-large size-large"></a>
              </div>
            </div>

            <!-- Nav -->
            <div class="elementor-element elementor-element-e3ef480 elementor-widget elementor-widget-ekit-nav-menu" data-widget_type="ekit-nav-menu.default">
              <div class="elementor-widget-container">
                <nav class="ekit-wid-con ekit_menu_responsive_tablet" data-hamburger-icon="" data-hamburger-icon-type="icon" data-responsive-breakpoint="1024">
                  <button class="elementskit-menu-hamburger elementskit-menu-toggler" type="button" aria-label="hamburger-icon">
                    <span class="elementskit-menu-hamburger-icon"></span><span class="elementskit-menu-hamburger-icon"></span><span class="elementskit-menu-hamburger-icon"></span>
                  </button>
                  <div id="ekit-megamenu-menu-1" class="elementskit-menu-container elementskit-menu-offcanvas-elements elementskit-navbar-nav-default ekit-nav-menu-one-page-no ekit-nav-dropdown-hover">
                    <ul id="menu-menu-1" class="elementskit-navbar-nav elementskit-menu-po-center submenu-click-on-icon">
                      <li class="menu-item menu-item-home nav-item elementskit-mobile-builder-content<?= $is('') ?>"><a href="<?= url('') ?>" class="ekit-menu-nav-link<?= $is('') ?>">Home</a></li>
                      <li class="menu-item menu-item-has-children nav-item elementskit-dropdown-has relative_position elementskit-mobile-builder-content">
                        <a href="<?= url('about') ?>" class="ekit-menu-nav-link ekit-menu-dropdown-toggle">About<i aria-hidden="true" class="icon icon-down-arrow1 elementskit-submenu-indicator"></i></a>
                        <ul class="elementskit-dropdown elementskit-submenu-panel">
                          <li class="menu-item nav-item"><a href="<?= url('about') ?>" class="dropdown-item">About Us</a></li>
                          <li class="menu-item nav-item"><a href="<?= url('team') ?>" class="dropdown-item">Our Team</a></li>
                        </ul>
                      </li>
                      <li class="menu-item menu-item-has-children nav-item elementskit-dropdown-has relative_position elementskit-mobile-builder-content">
                        <a href="<?= url('services') ?>" class="ekit-menu-nav-link ekit-menu-dropdown-toggle">Services<i aria-hidden="true" class="icon icon-down-arrow1 elementskit-submenu-indicator"></i></a>
                        <ul class="elementskit-dropdown elementskit-submenu-panel">
                          <li class="menu-item nav-item"><a href="<?= url('services') ?>" class="dropdown-item">Our Services</a></li>
                          <li class="menu-item nav-item"><a href="<?= url('pricing') ?>" class="dropdown-item">Our Pricing</a></li>
                        </ul>
                      </li>
                      <li class="menu-item nav-item elementskit-mobile-builder-content<?= $is('projects') ?>"><a href="<?= url('projects') ?>" class="ekit-menu-nav-link<?= $is('projects') ?>">Projects</a></li>
                      <li class="menu-item menu-item-has-children nav-item elementskit-dropdown-has relative_position elementskit-mobile-builder-content">
                        <a href="<?= url('blog') ?>" class="ekit-menu-nav-link ekit-menu-dropdown-toggle">Pages<i aria-hidden="true" class="icon icon-down-arrow1 elementskit-submenu-indicator"></i></a>
                        <ul class="elementskit-dropdown elementskit-submenu-panel">
                          <li class="menu-item nav-item"><a href="<?= url('blog') ?>" class="dropdown-item">Blog</a></li>
                          <li class="menu-item nav-item"><a href="<?= url('faqs') ?>" class="dropdown-item">FAQs</a></li>
                          <li class="menu-item nav-item"><a href="<?= url('testimonials') ?>" class="dropdown-item">Testimonials</a></li>
                          <li class="menu-item nav-item"><a href="<?= url('contact') ?>" class="dropdown-item">Contact Us</a></li>
                        </ul>
                      </li>
                    </ul>
                    <div class="elementskit-nav-identity-panel">
                      <a class="elementskit-nav-logo" href="<?= url('') ?>"><img src="<?= e($logo) ?>" alt="<?= e($biz) ?>" decoding="async"></a>
                      <button class="elementskit-menu-close elementskit-menu-toggler" type="button">X</button>
                    </div>
                  </div>
                  <div class="elementskit-menu-overlay elementskit-menu-offcanvas-elements elementskit-menu-toggler ekit-nav-menu--overlay"></div>
                </nav>
              </div>
            </div>
          </div>

          <!-- Get a Quotation -->
          <div class="elementor-element elementor-element-7e41127 e-con-full elementor-hidden-tablet elementor-hidden-mobile e-flex e-con e-child">
            <div class="elementor-element elementor-element-7b19bbc elementor-widget elementor-widget-button" data-widget_type="button.default">
              <div class="elementor-widget-container">
                <div class="elementor-button-wrapper">
                  <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('contact') ?>">
                    <span class="elementor-button-content-wrapper"><span class="elementor-button-text">Get a Quotation</span></span>
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div id="content" data-elementor-type="wp-page" data-elementor-id="1232" class="elementor elementor-1232">
