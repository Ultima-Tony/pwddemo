<?php
/** Contact page — processes the quote form and shows contact details. */
$source = isset($_POST['source']) && $_POST['source'] !== '' ? preg_replace('/[^a-z0-9_-]/i', '', $_POST['source']) : 'contact';
$quote_result = submit_quote($source);
// On success, clear POST so the form re-renders empty.
if ($quote_result['ok']) { $_POST = []; }

$seo_opts = ['title' => 'Contact Us', 'description' => 'Get a free estimate from ' . setting('site_name', SITE_NAME) . '. Call ' . setting('contact_phone', '') . '.', 'path' => 'contact'];
require __DIR__ . '/partials/header.php';
$page_title = 'Contact Us';
$crumbs = [['Home', url('')], ['Contact', null]];
require __DIR__ . '/partials/breadcrumb.php';

$phone = setting('contact_phone', '');
$email = setting('contact_email', SITE_EMAIL);
$addr  = trim(setting('contact_address', '') . ', ' . setting('contact_city', '') . ', ' . setting('contact_region', '') . ' ' . setting('contact_postal', ''), ', ');
$hours = setting('contact_hours', '');
?>
<div class="ltk-section"><div class="ltk-container">
  <div class="ltk-grid" style="grid-template-columns:minmax(0,1fr) minmax(0,1.4fr);align-items:start">
    <div class="ltk-editable">
      <?= edit_btn('settings', 'Contact details') ?>
      <h3 class="ekit-heading--title" style="margin-bottom:18px">Get In Touch</h3>
      <ul class="elementor-icon-list-items" style="list-style:none;padding:0;line-height:2.2">
        <?php if ($addr): ?><li><i class="icon icon-location" aria-hidden="true"></i> <?= e($addr) ?></li><?php endif; ?>
        <?php if ($phone): ?><li><i class="icon icon-phone1" aria-hidden="true"></i> <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"><?= e($phone) ?></a></li><?php endif; ?>
        <?php if ($email): ?><li><i class="icon icon-email1" aria-hidden="true"></i> <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></li><?php endif; ?>
        <?php if ($hours): ?><li><i class="icon icon-clock" aria-hidden="true"></i> <?= e($hours) ?></li><?php endif; ?>
      </ul>
      <?php if ($addr): ?>
      <div style="margin-top:20px;border-radius:12px;overflow:hidden">
        <iframe title="Map" width="100%" height="280" style="border:0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps?q=<?= urlencode($addr) ?>&output=embed"></iframe>
      </div>
      <?php endif; ?>
    </div>
    <div>
      <?php require __DIR__ . '/sections/contact_cta.php'; ?>
    </div>
  </div>
</div></div>
<?php require __DIR__ . '/partials/footer.php'; ?>
