<?php
/** Homepage — renders enabled sections in the order set by the sections table. */
$seo_opts = [
    'title'       => '',
    'description' => setting('meta_description', ''),
    'path'        => '',
    'image'       => setting('og_image', ''),
];
$body_class = 'ltk-home';
require __DIR__ . '/partials/header.php';

foreach (sections_layout() as $s) {
    $key  = $s['section_key'];
    $file = __DIR__ . '/sections/' . basename($key) . '.php';
    if (is_file($file)) {
        require $file;
    }
}

require __DIR__ . '/partials/footer.php';
