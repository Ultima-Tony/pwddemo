/* Demo Contracting Ltd — front-end behaviour (vanilla, no Elementor runtime). */
(function () {
  'use strict';
  var d = document;
  function ready(fn) {
    if (d.readyState !== 'loading') fn();
    else d.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    mobileMenu();
    accordion();
    counters();
    testimonialSlider();
    videoPopup();
    editPencil();
  });

  /* ---- Mobile nav (ElementsKit offcanvas) ---- */
  function mobileMenu() {
    var nav = d.querySelector('.ekit_menu_responsive_tablet');
    if (!nav) return;
    var menu = nav.querySelector('#ekit-megamenu-menu-1');
    var open = nav.querySelectorAll('.elementskit-menu-hamburger');
    var close = nav.querySelectorAll('.elementskit-menu-close, .ekit-nav-menu--overlay');
    function setOpen(v) { nav.classList.toggle('ltk-nav-open', v); d.body.classList.toggle('ltk-noscroll', v); }
    open.forEach(function (b) { b.addEventListener('click', function (e) { e.preventDefault(); setOpen(!nav.classList.contains('ltk-nav-open')); }); });
    close.forEach(function (b) { b.addEventListener('click', function (e) { e.preventDefault(); setOpen(false); }); });
    // Mobile: tap a dropdown parent to expand its submenu.
    if (!menu) return;
    menu.querySelectorAll('.ekit-menu-dropdown-toggle').forEach(function (t) {
      t.addEventListener('click', function (e) {
        if (window.innerWidth > 1024) return; // desktop uses hover
        e.preventDefault();
        t.closest('.menu-item-has-children').classList.toggle('ltk-sub-open');
      });
    });
  }

  /* ---- FAQ accordion ---- */
  function accordion() {
    d.querySelectorAll('.elementskit-accordion').forEach(function (acc) {
      acc.querySelectorAll('.ekit-accordion--toggler').forEach(function (tog) {
        tog.addEventListener('click', function (e) {
          e.preventDefault();
          var card = tog.closest('.elementskit-card');
          var body = card.querySelector('.collapse');
          var isOpen = card.classList.contains('active');
          // close siblings
          acc.querySelectorAll('.elementskit-card').forEach(function (c) {
            c.classList.remove('active');
            var b = c.querySelector('.collapse');
            if (b) b.classList.remove('show');
            var a = c.querySelector('.ekit-accordion--toggler');
            if (a) a.setAttribute('aria-expanded', 'false');
          });
          if (!isOpen) {
            card.classList.add('active');
            if (body) body.classList.add('show');
            tog.setAttribute('aria-expanded', 'true');
          }
        });
      });
    });
  }

  /* ---- Counter number animation ---- */
  function counters() {
    var nums = d.querySelectorAll('.elementor-counter-number');
    if (!nums.length) return;
    function animate(el) {
      var to = parseFloat(el.getAttribute('data-to-value')) || 0;
      var from = parseFloat(el.getAttribute('data-from-value')) || 0;
      var dur = parseInt(el.getAttribute('data-duration'), 10) || 2000;
      var delim = el.getAttribute('data-delimiter') || ',';
      var start = null;
      function fmt(n) {
        n = Math.round(n).toString();
        return n.replace(/\B(?=(\d{3})+(?!\d))/g, delim);
      }
      function step(ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / dur, 1);
        el.textContent = fmt(from + (to - from) * p);
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    }
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { animate(en.target); io.unobserve(en.target); }
        });
      }, { threshold: 0.4 });
      nums.forEach(function (n) { io.observe(n); });
    } else {
      nums.forEach(animate);
    }
  }

  /* ---- Testimonial slider (Swiper) ---- */
  function testimonialSlider() {
    if (typeof Swiper === 'undefined') return;
    d.querySelectorAll('.elementskit-testimonial-slider .ekit-main-swiper').forEach(function (el) {
      new Swiper(el, {
        slidesPerView: 1, spaceBetween: 30, loop: el.querySelectorAll('.swiper-slide').length > 1,
        autoplay: { delay: 5000 }, grabCursor: true,
        breakpoints: { 768: { slidesPerView: 1 }, 1024: { slidesPerView: 2 } }
      });
    });
  }

  /* ---- Video popup lightbox ---- */
  function videoPopup() {
    d.querySelectorAll('.ekit-video-popup-btn').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var src = btn.getAttribute('href');
        if (!src) return;
        var ov = d.createElement('div');
        ov.className = 'ltk-video-overlay';
        ov.innerHTML = '<div class="ltk-video-box"><button class="ltk-video-close" aria-label="Close">&times;</button>' +
          '<div class="ltk-video-frame"><iframe src="' + src + (src.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1" allow="autoplay; fullscreen" allowfullscreen frameborder="0"></iframe></div></div>';
        d.body.appendChild(ov);
        function kill() { ov.remove(); }
        ov.addEventListener('click', function (ev) { if (ev.target === ov || ev.target.classList.contains('ltk-video-close')) kill(); });
        d.addEventListener('keydown', function esc(ev) { if (ev.key === 'Escape') { kill(); d.removeEventListener('keydown', esc); } });
      });
    });
  }

  /* ---- Floating admin edit pencil ----
     One fixed, max-z-index button that follows whichever .ltk-editable region
     is hovered. Beats the template's stacking contexts (a plain absolute button
     gets covered). Deep-links to the editor via the region's <a.ltk-edit href>. */
  function editPencil() {
    var regions = d.querySelectorAll('.ltk-editable');
    if (!regions.length) return;
    var pencil = d.createElement('a');
    pencil.className = 'ltk-pencil';
    pencil.innerHTML = '<span aria-hidden="true">&#9998;</span>';
    pencil.style.display = 'none';
    d.body.appendChild(pencil);
    var hideT = null;
    function show(region) {
      var marker = region.querySelector(':scope > .ltk-edit') || region.querySelector('.ltk-edit');
      if (!marker) return;
      var r = region.getBoundingClientRect();
      pencil.href = marker.getAttribute('href');
      pencil.title = 'Edit: ' + (marker.getAttribute('data-label') || 'section');
      pencil.style.top = (window.scrollY + r.top + 12) + 'px';
      pencil.style.left = (window.scrollX + r.right - 52) + 'px';
      pencil.style.display = 'flex';
      if (hideT) { clearTimeout(hideT); hideT = null; }
    }
    function scheduleHide() { hideT = setTimeout(function () { pencil.style.display = 'none'; }, 250); }
    regions.forEach(function (region) {
      region.addEventListener('mouseenter', function () { show(region); });
      region.addEventListener('mouseleave', scheduleHide);
    });
    pencil.addEventListener('mouseenter', function () { if (hideT) { clearTimeout(hideT); hideT = null; } });
    pencil.addEventListener('mouseleave', scheduleHide);
  }
})();
