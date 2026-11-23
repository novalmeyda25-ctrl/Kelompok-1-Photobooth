(function () {
  'use strict';
  var html = document.documentElement;
  var root = document.getElementById('hero-lotus');
  var lotus = document.getElementById('hero-lotus-inner');
  var text = document.getElementById('hero-text');
  if (!root || !lotus || !window.WBLotus) { html.classList.remove('wb-arriving'); return; }

  var arriving = html.classList.contains('wb-arriving');
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function finish() {
    html.classList.remove('wb-arriving', 'wb-veil-off');
    lotus.style.transition = '';
    lotus.style.transform = '';
    if (text) { text.classList.remove('hero-arrive', 'hero-in'); }
    root.classList.remove('wb-instant');
  }

  function run() {
    root.classList.add('wb-bloomed', 'wb-instant');
    if (!arriving) return;
    if (reduced) { finish(); return; }

    window.scrollTo(0, 0);
    var r = lotus.getBoundingClientRect();
    var cx = r.left + r.width / 2;
    var cy = r.top + r.height * 0.53;
    var s = Math.min(window.innerWidth * 1.0, window.innerHeight * 0.9 * 1.5) / r.width;

    lotus.style.transition = 'none';
    lotus.style.transform = 'translate(' + (window.innerWidth / 2 - cx) + 'px,' + (window.innerHeight / 2 - cy) + 'px) scale(' + s + ')';
    if (text) { text.classList.add('hero-arrive'); }
    void lotus.offsetWidth;

    requestAnimationFrame(function () { html.classList.add('wb-veil-off'); });
    setTimeout(function () {
      lotus.style.transition = 'transform 2s cubic-bezier(.55,.05,.35,1)';
      lotus.style.transform = 'none';
    }, 700);
    setTimeout(function () { if (text) text.classList.add('hero-in'); }, 1300);
    setTimeout(finish, 3600);
  }

  WBLotus.prepare(root, root.dataset.photo, run);
})();