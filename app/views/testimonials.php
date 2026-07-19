<?php
/** Testimonials page. */
$seo_opts = ['title' => 'Testimonials', 'description' => 'What homeowners say about working with ' . setting('site_name', SITE_NAME) . '.', 'path' => 'testimonials'];
require __DIR__ . '/partials/header.php';
$page_title = 'Testimonials';
$crumbs = [['Home', url('')], ['Testimonials', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/testimonials.php';
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
