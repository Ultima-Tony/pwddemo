<?php
/** About Us page. */
$seo_opts = ['title' => 'About Us', 'description' => 'Learn about ' . setting('site_name', SITE_NAME) . ', a full-service contracting company serving Saskatchewan.', 'path' => 'about'];
require __DIR__ . '/partials/header.php';
$page_title = 'About Us';
$crumbs = [['Home', url('')], ['About Us', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/about.php';
require __DIR__ . '/sections/counters.php';
require __DIR__ . '/sections/features.php';
require __DIR__ . '/sections/testimonials.php';
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
