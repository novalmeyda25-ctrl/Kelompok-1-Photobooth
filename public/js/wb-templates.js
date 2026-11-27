// public/js/wb-templates.js
// Data template + renderer bersama (dipakai home & download).
//
// Satu template = { id, name, kind, width, height, slots:[...], ... }
//  - kind 'image'   : template berupa gambar PNG buatan admin. Lubang foto = area TRANSPARAN,
//                     jadi dekorasi (kupu-kupu, peri, dll) tetap menimpa foto.
//                     layer:'over'  -> gambar digambar DI ATAS foto (lubang transparan)  [default]
//                     layer:'under' -> gambar digambar DI BAWAH foto (lubang tidak transparan)
//  - kind 'classic' : strip warna polos bawaan (tanpa gambar), jumlah foto = count (1-4+).
//
// Slot (posisi foto), semua dalam PIXEL ASLI gambar template:
//   { cx, cy, w, h, rot }  -> titik tengah, lebar, tinggi, rotasi (derajat; boleh miring)
//   atau { x, y, w, h }    -> pojok kiri-atas (tanpa rotasi)
// Jumlah slot = jumlah foto yang harus diambil user (1, 2, 3, 4, dst).
//
// Backend bisa mengisi daftar template dari database lewat window.WB_TEMPLATES
// (lihat home.blade.php). Kalau kosong, dipakai DEFAULT di bawah.
(function (root) {
  const BASE = (root.WB_TPL_BASE || '/img/templates').replace(/\/$/, '');

  // ---------- strip warna polos (classic) ----------
  const CLASSIC = { W: 600, SLOT_W: 500, SLOT_H: 340, GAP: 40, TOP: 100, X: 50 };
  function classicSlots(n) {
    const out = [];
    for (let i = 0; i < n; i++) {
      out.push({
        cx: CLASSIC.X + CLASSIC.SLOT_W / 2,
        cy: CLASSIC.TOP + i * (CLASSIC.SLOT_H + CLASSIC.GAP) + CLASSIC.SLOT_H / 2,
        w: CLASSIC.SLOT_W, h: CLASSIC.SLOT_H, rot: 0
      });
    }
    return out;
  }
  function classic(id, name, bg, count) {
    return normalize({ id: id, name: name, kind: 'classic', bg: bg, count: count || 4 });
  }

  function normalize(t) {
    const o = Object.assign({}, t);
    o.kind = o.image ? 'image' : (o.kind || 'classic');
    if (o.kind === 'classic') {
      const n = Math.max(1, parseInt(o.count || (o.slots && o.slots.length) || 4, 10));
      o.slots = classicSlots(n);
      o.width = CLASSIC.W;
      o.height = n * (CLASSIC.SLOT_H + CLASSIC.GAP) + 280 - 0; // n=4 -> 1800 (sama seperti sebelumnya)
      o.bg = o.bg || '#FFF0F4';
    } else {
      o.layer = o.layer === 'under' ? 'under' : 'over';
      o.slots = (o.slots || []).map(function (s) {
        if (s.cx != null) return { cx: +s.cx, cy: +s.cy, w: +s.w, h: +s.h, rot: +(s.rot || 0) };
        return { cx: +s.x + s.w / 2, cy: +s.y + s.h / 2, w: +s.w, h: +s.h, rot: 0 };
      });
    }
    o.count = o.slots.length;
    return o;
  }

  // ---------- template DUMMY (contoh saja, tanpa file gambar) ----------
  // Dibuat dari SVG inline dengan lubang transparan, supaya jalur "template gambar dari admin"
  // tetap teruji. Template asli dari admin akan menggantikan ini (lihat window.WB_TEMPLATES).
  function dummy(id, name, color, count) {
    const W = 600, SW = 500, SH = 340, GAP = 40, TOP = 90, H = TOP + count * SH + (count - 1) * GAP + 110;
    let holes = '', slots = [];
    for (let i = 0; i < count; i++) {
      const y = TOP + i * (SH + GAP);
      holes += 'M50 ' + y + 'h' + SW + 'v' + SH + 'h-' + SW + 'z';
      slots.push({ cx: W / 2, cy: y + SH / 2, w: SW + 6, h: SH + 6 });
    }
    const svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' + W + '" height="' + H + '" viewBox="0 0 ' + W + ' ' + H + '">'
      + '<path fill-rule="evenodd" fill="' + color + '" d="M0 0h' + W + 'v' + H + 'h-' + W + 'z' + holes + '"/>'
      + '<text x="300" y="58" text-anchor="middle" font-family="serif" font-size="26" font-weight="bold" fill="#970046">DUMMY TEMPLATE</text>'
      + '<text x="300" y="' + (H - 45) + '" text-anchor="middle" font-family="sans-serif" font-size="16" fill="#8D7075">' + count + ' foto</text></svg>';
    return normalize({
      id: id, name: name, tagline: 'Contoh template · ' + count + ' foto',
      image: 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg),
      width: W, height: H, layer: 'over', slots: slots,
      accent: 'linear-gradient(135deg,' + color + ',#fff)'
    });
  }

  // ---------- template bawaan ----------
  const DEFAULTS = [
    classic('garden', 'Garden', '#FFF0F4', 4),
    classic('fairy-whispers', 'Fairy Whispers', '#FAF5FF', 4),
    classic('sweet-memories', 'Sweet Memories', '#FFFBEB', 4),
    classic('blush-petals', 'Blush Petals', '#FFF0F5', 4),
    dummy('dummy-1', 'Dummy 1 Foto', '#FDE2EF', 1),
    dummy('dummy-2', 'Dummy 2 Foto', '#EBDDFB', 2),
    dummy('dummy-3', 'Dummy 3 Foto', '#FFE9C9', 3)
  ];

  function list() {
    const src = Array.isArray(root.WB_TEMPLATES) && root.WB_TEMPLATES.length ? root.WB_TEMPLATES : null;
    return src ? src.map(normalize) : DEFAULTS;
  }
  function find(id) { return list().filter(function (t) { return t.id === id; })[0] || null; }

  // ---------- util gambar ----------
  function loadImg(src) {
    return new Promise(function (res) {
      if (!src) return res(null);
      const im = new Image(); im.crossOrigin = 'anonymous';
      im.onload = function () { res(im); }; im.onerror = function () { res(null); }; im.src = src;
    });
  }
  function cover(ctx, im, x, y, w, h) {
    if (!im) { ctx.fillStyle = '#FFE4E8'; ctx.fillRect(x, y, w, h); return; }
    const r = Math.max(w / im.width, h / im.height), sw = w / r, sh = h / r;
    ctx.drawImage(im, (im.width - sw) / 2, (im.height - sh) / 2, sw, sh, x, y, w, h);
  }

  // Ukuran hasil file (px) untuk sebuah template
  function outputSize(t, kind) {
    const pngW = t.kind === 'classic' ? 1200 : t.width;
    const w = kind === 'jpg' ? Math.round(pngW / 2) : kind === 'zoom' ? 360 : pngW;
    return { w: w, h: Math.round(t.height * w / t.width) };
  }

  // ---------- render ke canvas ----------
  async function render(t, urls, opt) {
    opt = opt || {};
    const n = t.slots.length;
    const photos = await Promise.all(urls.slice(0, n).map(loadImg));
    const tplImg = t.kind === 'image' ? await loadImg(t.image) : null;
    const w = opt.width || t.width, s = w / t.width, h = Math.round(t.height * s);
    const c = document.createElement('canvas'); c.width = w; c.height = h;
    const ctx = c.getContext('2d'); ctx.scale(s, s);

    if (t.kind === 'classic') {
      ctx.fillStyle = opt.bg || t.bg; ctx.fillRect(0, 0, t.width, t.height);
      ctx.strokeStyle = '#FBCFE8'; ctx.lineWidth = 14; ctx.strokeRect(7, 7, t.width - 14, t.height - 14);
      ctx.fillStyle = '#970046'; ctx.font = 'bold 26px "Playfair Display", serif'; ctx.textAlign = 'center';
      ctx.fillText('✿  WHIMSHYBOOTH  ✿', t.width / 2, 70);
      t.slots.forEach(function (sl, i) {
        const x = sl.cx - sl.w / 2, y = sl.cy - sl.h / 2;
        cover(ctx, photos[i], x, y, sl.w, sl.h);
        ctx.strokeStyle = '#FBCFE8'; ctx.lineWidth = 4; ctx.strokeRect(x, y, sl.w, sl.h);
      });
      ctx.fillStyle = '#8D7075'; ctx.font = '16px "Plus Jakarta Sans", sans-serif';
      ctx.fillText('MADE WITH A LITTLE MAGIC ♡', t.width / 2, t.height - 45);
      return c;
    }

    ctx.fillStyle = '#fff'; ctx.fillRect(0, 0, t.width, t.height);
    if (tplImg && t.layer === 'under') ctx.drawImage(tplImg, 0, 0, t.width, t.height);
    t.slots.forEach(function (sl, i) {
      ctx.save();
      ctx.translate(sl.cx, sl.cy); ctx.rotate((sl.rot || 0) * Math.PI / 180);
      ctx.beginPath(); ctx.rect(-sl.w / 2, -sl.h / 2, sl.w, sl.h); ctx.clip();
      cover(ctx, photos[i], -sl.w / 2, -sl.h / 2, sl.w, sl.h);
      ctx.restore();
    });
    if (tplImg && t.layer !== 'under') ctx.drawImage(tplImg, 0, 0, t.width, t.height);
    return c;
  }

  // posisi slot dalam persen (untuk preview HTML)
  function slotBox(t, i) {
    const s = t.slots[i];
    return {
      left: ((s.cx - s.w / 2) / t.width * 100) + '%', top: ((s.cy - s.h / 2) / t.height * 100) + '%',
      width: (s.w / t.width * 100) + '%', height: (s.h / t.height * 100) + '%',
      rot: s.rot || 0
    };
  }

  root.WBTpl = {
    list: list, find: find, classic: classic, normalize: normalize,
    render: render, slotBox: slotBox, outputSize: outputSize, loadImg: loadImg, cover: cover
  };
})(window);
