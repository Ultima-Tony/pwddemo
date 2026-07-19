<?php
/** Our Services page. */
$seo_opts = ['title' => 'Our Services', 'description' => 'Explore the contracting and home-improvement services offered by ' . setting('site_name', SITE_NAME) . '.', 'path' => 'services'];
require __DIR__ . '/partials/header.php';
$page_title = 'Our Services';
$crumbs = [['Home', url('')], ['Services', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/services.php';
require __DIR__ . '/sections/process.php';
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
