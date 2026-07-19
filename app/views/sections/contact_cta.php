<?php
/** Contact CTA + quote form (container 37f95d8b). Posts to /contact for processing. */
$b        = block('contact_cta');
$services = items('services');
$q        = $quote_result ?? null; // set when the contact page renders this after a POST
?>
<div class="elementor-element elementor-element-37f95d8b e-flex e-con-boxed e-con e-parent ltk-editable" id="quote" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
  <?= edit_btn('blocks?block=contact_cta', 'Contact CTA') ?>
  <div class="e-con-inner">
    <div class="elementor-element elementor-element-6b7f6a40 e-con-full e-flex e-con e-child animated fadeInLeft">
      <?= ekit_eyebrow($b['eyebrow']) ?>
      <?= ekit_heading($b['heading'], 'left') ?>
      <div class="elementor-element elementor-widget elementor-widget-text-editor" data-widget_type="text-editor.default">
        <div class="elementor-widget-container"><p><?= e($b['body']) ?></p></div>
      </div>

      <?php if ($q && $q['ok']): ?>
        <div class="ltk-alert ok">Thank you — your request has been received. We'll be in touch within one business day.</div>
      <?php elseif ($q && $q['errors']): ?>
        <div class="ltk-alert err"><?= e(implode(' ', $q['errors'])) ?></div>
      <?php endif; ?>

      <form class="ltk-quote-form" method="post" action="<?= url('contact') ?>#quote">
        <?= csrf_field() ?>
        <input type="hidden" name="source" value="homepage">
        <div class="ltk-hp"><label>Leave this empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="ltk-grid cols-2">
          <div class="ltk-field"><label for="q-name">Name</label><input id="q-name" type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>"></div>
          <div class="ltk-field"><label for="q-email">Email</label><input id="q-email" type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></div>
          <div class="ltk-field"><label for="q-phone">Phone</label><input id="q-phone" type="tel" name="phone" value="<?= e($_POST['phone'] ?? '') ?>"></div>
          <div class="ltk-field"><label for="q-service">Service</label>
            <select id="q-service" name="service">
              <option value="">Select a service…</option>
              <?php foreach ($services as $s): ?>
              <option value="<?= e(html_entity_decode(strip_tags($s['title']))) ?>"><?= $s['title'] ?></option>
              <?php endforeach; ?>
              <option value="Other">Other / not sure</option>
            </select>
          </div>
        </div>
        <div class="ltk-field"><label for="q-message">Project details</label><textarea id="q-message" name="message" rows="5" required><?= e($_POST['message'] ?? '') ?></textarea></div>
        <div class="elementor-button-wrapper">
          <button type="submit" class="elementor-button elementor-button-link elementor-size-sm elementor-animation-float">
            <span class="elementor-button-content-wrapper"><span class="elementor-button-text">Request My Free Estimate</span></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
