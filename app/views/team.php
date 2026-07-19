<?php
/** Our Team page. */
$seo_opts = ['title' => 'Our Team', 'description' => 'Meet the crew behind ' . setting('site_name', SITE_NAME) . '.', 'path' => 'team'];
require __DIR__ . '/partials/header.php';
$page_title = 'Our Team';
$crumbs = [['Home', url('')], ['Team', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/team.php';
require __DIR__ . '/sections/cta_banner.php';
require __DIR__ . '/partials/footer.php';
