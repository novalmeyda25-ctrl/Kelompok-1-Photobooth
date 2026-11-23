window.WBLotus = {
  prepare: function (root, url, done) {
    function finish() { root.classList.add('is-ready'); if (done) done(); }
    var im = new Image();
    im.onerror = finish;
    im.onload = function () {
      try {
        var c = document.createElement('canvas');
        c.width = im.naturalWidth; c.height = im.naturalHeight;
        var ctx = c.getContext('2d');
        ctx.drawImage(im, 0, 0);
        var d = ctx.getImageData(0, 0, c.width, c.height), px = d.data;
        var br = px[0], bg = px[1], bb = px[2], ba = px[3];
        if (ba < 240 || Math.max(br, bg, bb) > 110) { finish(); return; }
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
          if (blob) { root.style.setProperty('--wb-photo', 'url("' + URL.createObjectURL(blob) + '")'); }
          finish();
        }, 'image/png');
      } catch (e) { finish(); }
    };
    im.src = url;
  }
};