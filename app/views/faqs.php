<?php
/** FAQs page (with FAQPage JSON-LD). */
$faqs = items('faq');
$seo_opts = ['title' => 'FAQs', 'description' => 'Answers to common questions about ' . setting('site_name', SITE_NAME) . '.', 'path' => 'faqs'];
$extra_head_jsonld = faq_jsonld($faqs);
require __DIR__ . '/partials/header.php';
$page_title = 'Frequently Asked Questions';
$crumbs = [['Home', url('')], ['FAQs', null]];
require __DIR__ . '/partials/breadcrumb.php';
require __DIR__ . '/sections/faq.php';
require __DIR__ . '/sections/contact_cta.php';
require __DIR__ . '/partials/footer.php';
