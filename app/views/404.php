<?php
/** 404 page. */
if (!headers_sent()) { http_response_code(404); }
$seo_opts = ['title' => 'Page Not Found', 'description' => 'The page you were looking for could not be found.', 'path' => ''];
require __DIR__ . '/partials/header.php';
?>
<div class="ltk-page-hero">
  <div class="ltk-container">
    <h1 style="font-size:clamp(3rem,10vw,6rem)">404</h1>
    <p style="font-size:1.25rem;margin-bottom:24px">Sorry, we couldn't find that page.</p>
    <a class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float" href="<?= url('') ?>"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Back to Home</span></span></a>
  </div>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
