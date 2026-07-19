<?php
/** Our Pricing page. */
$seo_opts = ['title' => 'Our Pricing', 'description' => 'Flexible contracting packages from ' . setting('site_name', SITE_NAME) . '.', 'path' => 'pricing'];
require __DIR__ . '/partials/header.php';
$page_title = 'Our Pricing';
$crumbs = [['Home', url('')], ['Pricing', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/pricing.php';
require __DIR__ . '/sections/faq.php';
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
