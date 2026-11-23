(function () {
  'use strict';
  var stage = document.getElementById('wbStage');
  var btn = document.getElementById('wbEnter');
  var lotus = document.getElementById('wbLotus');
  var sparkles = document.getElementById('wbSparkles');
  if (!stage || !btn || !lotus) return;

  var homeUrl = stage.dataset.homeUrl;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var running = false;

  function setZoom() {
    var r = lotus.getBoundingClientRect();
    var cx = r.left + r.width / 2;
    var cy = r.top + r.height * 0.53;
    stage.style.setProperty('--wb-dx', (window.innerWidth / 2 - cx).toFixed(1) + 'px');
    stage.style.setProperty('--wb-dy', (window.innerHeight / 2 - cy).toFixed(1) + 'px');
    var target = Math.min(window.innerWidth * 1.0, window.innerHeight * 0.9 * 1.5);
    stage.style.setProperty('--wb-zoom', (target / r.width * 0.80).toFixed(2));
  }

  function spawnSparkles(count) {
    for (var i = 0; i < count; i++) {
      var s = document.createElement('i');
      s.className = 'wb-sparkle';
      s.style.left = (Math.random() * 100) + '%';
      s.style.top = (20 + Math.random() * 70) + '%';
      s.style.setProperty('--s', (8 + Math.random() * 24) + 'px');
      s.style.setProperty('--d', (1.2 + Math.random() * 1.4) + 's');
      s.style.setProperty('--delay', (Math.random() * 3) + 's');
      sparkles.appendChild(s);
    }
  }

  function go() { window.location.href = homeUrl; }
  function at(ms, cls) { setTimeout(function () { stage.classList.add(cls); }, ms); }

  function start() {
    if (running) return;
    running = true;
    btn.disabled = true;
    stage.classList.add('is-running');

    if (reduced) {
      stage.classList.add('is-fading');
      setTimeout(go, 500);
      return;
    }

    setZoom();
    spawnSparkles(window.innerWidth < 600 ? 18 : 34);
    at(300,  'is-bloom');
    setTimeout(function () {
    spawnSparkles(window.innerWidth < 600 ? 90 : 140);
}, 300);
    at(3400, 'is-zooming');
    at(5200, 'is-fading');
    setTimeout(go, 6300);
  }

  btn.addEventListener('click', start);
  window.addEventListener('resize', function () { if (!running) setZoom(); });

  function ready() { stage.classList.add('is-ready'); }
  var photoUrl = stage.dataset.photo;
  var im = new Image();
  im.onerror = ready;
  im.onload = function () {
    try {
      var c = document.createElement('canvas');
      c.width = im.naturalWidth; c.height = im.naturalHeight;
      var ctx = c.getContext('2d');
      ctx.drawImage(im, 0, 0);
      var d = ctx.getImageData(0, 0, c.width, c.height), px = d.data;
      var br = px[0], bg = px[1], bb = px[2], ba = px[3];
      if (ba < 240 || Math.max(br, bg, bb) > 110) { ready(); return; }
      for (var k = 0; k < px.length; k += 4) {
        var m = Math.max(px[k], px[k + 1], px[k + 2]);
        var a = (m - 85) / 35;
        if (a <= 0) { px[k + 3] = 0; continue; }
        if (a >= 1) continue;
        px[k]     = Math.min(255, Math.max(0, (px[k]     - br * (1 - a)) / a));
        px[k + 1] = Math.min(255, Math.max(0, (px[k + 1] - bg * (1 - a)) / a));
        px[k + 2] = Math.min(255, Math.max(0, (px[k + 2] - bb * (1 - a)) / a));
        px[k + 3] = a * 255;
      }
      ctx.putImageData(d, 0, 0);
      c.toBlob(function (blob) {
        if (blob) { stage.style.setProperty('--wb-photo', 'url("' + URL.createObjectURL(blob) + '")'); }
        ready();
      }, 'image/png');
    } catch (e) { ready(); }
  };
  im.src = photoUrl;

  window.addEventListener('pageshow', function (e) { if (e.persisted) location.reload(); });

  // =====================================
  // INTERACTIVE WHIMSYBOOTH
  // =====================================

  var photoCards = document.querySelectorAll('.wb-photo-card');
  var logo = document.querySelector('.wb-logo');
  var lotus = document.querySelector('#wbLotus');

  // 1. Setiap huruf logo bergerak sendiri
  if (logo) {
      var text = logo.textContent.trim();
      logo.innerHTML = '';

      text.split('').forEach(function (char) {
          var span = document.createElement('span');

          span.textContent = char === ' ' ? '\u00A0' : char;
          span.style.display = 'inline-block';
          span.style.transition =
              'transform .3s ease, text-shadow .3s ease';

          span.addEventListener('mouseenter', function () {
              span.style.transform = 'translateY(-8px) scale(1.2)';
              span.style.textShadow =
                  '0 0 8px #fff, 0 0 15px #ed69ad';
          });

          span.addEventListener('mouseleave', function () {
              span.style.transform = '';
              span.style.textShadow = '';
          });

          logo.appendChild(span);
      });
  }

  // 2. Foto mengikuti gerakan kursor
  stage.addEventListener('mousemove', function (e) {
      if (window.innerWidth < 768 || running) return;

      var x = (e.clientX / window.innerWidth - 0.5);
      var y = (e.clientY / window.innerHeight - 0.5);

      photoCards.forEach(function (photo, index) {
          var direction = index === 0 ? -1 : 1;

          photo.style.translate =
              (x * 14 * direction) + 'px ' +
              (y * 12) + 'px';
      });
  });

  stage.addEventListener('mouseleave', function () {
      photoCards.forEach(function (photo) {
          photo.style.translate = '0 0';
      });
  });

  // 3. Bunga bereaksi saat kursor diarahkan
  if (lotus) {
      lotus.addEventListener('mouseenter', function () {
          if (!running) {
              lotus.style.transition = 'transform .5s ease';
              lotus.style.scale = '1.025';
          }
      });

      lotus.addEventListener('mouseleave', function () {
          lotus.style.scale = '';
      });
  }

  // 4. Sparkle mengikuti kursor
  stage.addEventListener('mousemove', function (e) {
      if (window.innerWidth < 768 || running || reduced) return;
      if (Math.random() > 0.12) return;

      var sparkle = document.createElement('i');

      sparkle.className = 'wb-sparkle';
      sparkle.style.left = e.offsetX + 'px';
      sparkle.style.top = e.offsetY + 'px';
      sparkle.style.setProperty('--s', '8px');
      sparkle.style.setProperty('--d', '1s');
      sparkle.style.setProperty('--delay', '0s');

      sparkles.appendChild(sparkle);

      setTimeout(function () {
          sparkle.remove();
      }, 1100);
  });
})();