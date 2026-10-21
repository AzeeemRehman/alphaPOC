(function () {
  'use strict';

  // Mobile menu
  var toggle = document.getElementById('menu-toggle');
  var menu = document.getElementById('mobile-menu');
  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      var open = menu.classList.toggle('hidden') === false;
      toggle.setAttribute('aria-expanded', String(open));
    });
  }

  // Disable submit button after first click to stop double submissions
  document.querySelectorAll('form[data-once]').forEach(function (form) {
    form.addEventListener('submit', function () {
      var btn = form.querySelector('button[type=submit]');
      if (btn && form.checkValidity()) {
        btn.disabled = true;
        btn.dataset.label = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending…';
      }
    });
  });

  // Confirm destructive actions
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.confirm(form.dataset.confirm)) e.preventDefault();
    });
  });

  // Auto-slug in admin post form
  var title = document.getElementById('f_title');
  var slug = document.getElementById('f_slug');
  if (title && slug && !slug.value) {
    title.addEventListener('input', function () {
      if (slug.dataset.touched) return;
      slug.value = title.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    });
    slug.addEventListener('input', function () { slug.dataset.touched = '1'; });
  }
})();
