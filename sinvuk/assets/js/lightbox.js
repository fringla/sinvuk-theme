(function () {
  'use strict';

  var grid = document.querySelector('.gallery-grid');
  if (!grid) {
    return;
  }

  var items = Array.prototype.slice.call(grid.querySelectorAll('a.gallery-item'));
  if (!items.length) {
    return;
  }

  var index = 0;
  var isOpen = false;
  var lastFocus = null;
  var scrollY = 0;
  var touchStartX = 0;
  var touchStartY = 0;

  var root = document.createElement('div');
  root.className = 'lightbox';
  root.setAttribute('hidden', '');
  root.setAttribute('role', 'dialog');
  root.setAttribute('aria-modal', 'true');
  root.setAttribute('aria-label', 'Galerija');

  var backdrop = document.createElement('div');
  backdrop.className = 'lightbox-backdrop';

  var closeBtn = document.createElement('button');
  closeBtn.type = 'button';
  closeBtn.className = 'lightbox-close';
  closeBtn.setAttribute('aria-label', 'Zatvori');
  closeBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>';

  var prevBtn = document.createElement('button');
  prevBtn.type = 'button';
  prevBtn.className = 'lightbox-prev';
  prevBtn.setAttribute('aria-label', 'Prethodna');
  prevBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>';

  var nextBtn = document.createElement('button');
  nextBtn.type = 'button';
  nextBtn.className = 'lightbox-next';
  nextBtn.setAttribute('aria-label', 'Sledeća');
  nextBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>';

  var figure = document.createElement('figure');
  figure.className = 'lightbox-figure';

  var image = document.createElement('img');
  image.className = 'lightbox-image';
  image.alt = '';

  var caption = document.createElement('figcaption');
  caption.className = 'lightbox-caption';
  caption.hidden = true;

  var counter = document.createElement('div');
  counter.className = 'lightbox-counter';
  counter.setAttribute('aria-live', 'polite');

  figure.appendChild(image);
  figure.appendChild(caption);
  figure.appendChild(counter);

  root.appendChild(backdrop);
  root.appendChild(closeBtn);
  root.appendChild(prevBtn);
  root.appendChild(nextBtn);
  root.appendChild(figure);
  document.body.appendChild(root);

  function preload(i) {
    if (i < 0 || i >= items.length) {
      return;
    }
    var href = items[i].getAttribute('href');
    if (!href) {
      return;
    }
    var pre = new Image();
    pre.src = href;
  }

  function show(i) {
    index = (i + items.length) % items.length;
    var link = items[index];
    var thumb = link.querySelector('img');
    var src = link.getAttribute('href');
    var alt = thumb ? thumb.getAttribute('alt') || '' : '';

    image.classList.add('is-loading');
    image.onload = function () {
      image.classList.remove('is-loading');
    };
    image.onerror = function () {
      image.classList.remove('is-loading');
    };
    image.alt = alt;
    image.src = src;
    if (image.complete) {
      image.classList.remove('is-loading');
    }

    caption.textContent = alt;
    caption.hidden = !alt;
    counter.textContent = (index + 1) + ' / ' + items.length;

    var many = items.length > 1;
    prevBtn.hidden = !many;
    nextBtn.hidden = !many;

    if (many) {
      preload((index + 1) % items.length);
      preload((index - 1 + items.length) % items.length);
    }
  }

  function lockScroll() {
    scrollY = window.scrollY || window.pageYOffset || 0;
    document.body.classList.add('lightbox-open');
    document.body.style.position = 'fixed';
    document.body.style.top = '-' + scrollY + 'px';
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  }

  function unlockScroll() {
    document.body.classList.remove('lightbox-open');
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    document.body.style.width = '';
    var html = document.documentElement;
    var previous = html.style.scrollBehavior;
    html.style.scrollBehavior = 'auto';
    window.scrollTo(0, scrollY);
    html.style.scrollBehavior = previous;
  }

  function openAt(i) {
    lastFocus = document.activeElement;
    lockScroll();
    root.removeAttribute('hidden');
    isOpen = true;
    show(i);
    closeBtn.focus();
  }

  function closeLightbox() {
    if (!isOpen) {
      return;
    }
    isOpen = false;
    root.setAttribute('hidden', '');
    image.removeAttribute('src');
    unlockScroll();
    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
  }

  function isModifiedClick(event) {
    return event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey;
  }

  items.forEach(function (link, i) {
    link.addEventListener('click', function (event) {
      if (isModifiedClick(event)) {
        return;
      }
      event.preventDefault();
      openAt(i);
    });
  });

  closeBtn.addEventListener('click', closeLightbox);
  backdrop.addEventListener('click', closeLightbox);
  prevBtn.addEventListener('click', function () {
    show(index - 1);
  });
  nextBtn.addEventListener('click', function () {
    show(index + 1);
  });

  document.addEventListener('keydown', function (event) {
    if (!isOpen) {
      return;
    }
    if (event.key === 'Escape') {
      event.preventDefault();
      event.stopImmediatePropagation();
      closeLightbox();
      return;
    }
    if (event.key === 'ArrowLeft') {
      event.preventDefault();
      show(index - 1);
      return;
    }
    if (event.key === 'ArrowRight') {
      event.preventDefault();
      show(index + 1);
      return;
    }
    if (event.key === 'Tab') {
      var focusable = root.querySelectorAll('button:not([hidden])');
      if (!focusable.length) {
        return;
      }
      var first = focusable[0];
      var last = focusable[focusable.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    }
  }, true);

  root.addEventListener('touchstart', function (event) {
    if (!event.changedTouches || !event.changedTouches.length) {
      return;
    }
    touchStartX = event.changedTouches[0].clientX;
    touchStartY = event.changedTouches[0].clientY;
  }, { passive: true });

  root.addEventListener('touchend', function (event) {
    if (!isOpen || !event.changedTouches || !event.changedTouches.length) {
      return;
    }
    var dx = event.changedTouches[0].clientX - touchStartX;
    var dy = event.changedTouches[0].clientY - touchStartY;
    if (Math.abs(dx) < 50 || Math.abs(dx) < Math.abs(dy)) {
      return;
    }
    if (dx < 0) {
      show(index + 1);
    } else {
      show(index - 1);
    }
  }, { passive: true });
})();
