// public/js/download.js
document.addEventListener('DOMContentLoaded', () => {
  const HOME_URL = document.querySelector('.back-pill')?.href || '/';
  const FALLBACK = [
    'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80'
  ];
  // data strip dari home (sessionStorage 'wb_strip'): { images:[...], bg, frame, template }
  let strip = { images: [], bg: '#FFF0F4', frame: 'Garden', template: WBTpl.find('garden') || WBTpl.classic('garden', 'Garden', '#FFF0F4', 4) };
  try {
    const s = JSON.parse(sessionStorage.getItem('wb_strip') || 'null');
    if (s && Array.isArray(s.images)) {
      strip.template = s.template ? WBTpl.normalize(s.template) : strip.template;
      strip.images = s.images;
      strip.bg = s.bg || strip.template.bg || strip.bg;
      strip.frame = s.frame || strip.template.name;
    }
  } catch (e) {}
  const tpl = strip.template, N = tpl.slots.length;
  strip.images = Array.from({ length: N }, (_, i) => strip.images[i] || FALLBACK[i % FALLBACK.length]);

  const $ = (id) => document.getElementById(id);
  const toastEl = $('toast'); let toastTimer;
  function toast(msg, icon = 'auto_awesome') {
    $('toast-msg').textContent = msg; $('toast-icon').textContent = icon;
    toastEl.classList.remove('hidden'); clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toastEl.classList.add('hidden'), 3200);
  }

  // ---------- render strip (pratinjau) ----------
  const card = $('strip-card'), box = $('frames-container');
  card.style.setProperty('--strip-bg', strip.bg);
  if (tpl.kind === 'image') {
    card.classList.add('tpl-mode');
    const stage = document.createElement('div');
    stage.className = 'tpl-stage'; stage.style.aspectRatio = tpl.width + ' / ' + tpl.height;
    const overlay = () => { const im = document.createElement('img'); im.className = 'tpl-img'; im.alt = tpl.name; im.src = tpl.image; im.style.zIndex = tpl.layer === 'under' ? 0 : 2; return im; };
    if (tpl.layer === 'under') stage.appendChild(overlay());
    tpl.slots.forEach((sl, i) => {
      const b = WBTpl.slotBox(tpl, i), d = document.createElement('div'), im = document.createElement('img');
      d.className = 'tpl-slot';
      d.style.cssText = 'left:' + b.left + ';top:' + b.top + ';width:' + b.width + ';height:' + b.height + ';transform:rotate(' + b.rot + 'deg)';
      im.alt = 'Pose ' + (i + 1); im.src = strip.images[i]; d.appendChild(im); stage.appendChild(d);
    });
    if (tpl.layer !== 'under') stage.appendChild(overlay());
    box.insertBefore(stage, box.firstChild);
    const f = tpl.slots[0]; box.style.setProperty('--gif-ar', f.w + ' / ' + f.h);
  } else {
    strip.images.forEach((src, i) => {
      const it = document.createElement('div'); it.className = 'frame-item';
      const im = document.createElement('img'); im.alt = 'Pose ' + (i + 1); im.src = src;
      const sp = document.createElement('span'); sp.textContent = String(i + 1).padStart(2, '0');
      it.appendChild(im); it.appendChild(sp); box.insertBefore(it, $('gif-layer'));
    });
  }
  const pngSize = WBTpl.outputSize(tpl, 'png');
  $('spec-frame').textContent = strip.frame;
  $('spec-template').textContent = tpl.kind === 'classic' ? 'Classic ' + N + '-Cut Strip' : tpl.name + ' · ' + N + ' foto';
  $('strip-theme').textContent = strip.frame.toUpperCase() + ' • ' + N + '-CUT KEEPSAKE';
  $('png-desc').textContent = 'Strip ' + pngSize.w + ' × ' + pngSize.h + ' px, kualitas penuh tanpa kompresi — ideal untuk dicetak.';
  $('strip-date').textContent = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
  $('share-link').value = location.href;

  // ---------- auth ----------
  function refreshAuth() {
    const on = WBAuth.isLoggedIn();
    $('visitor-card').classList.toggle('hidden', on);
    $('auth-chip').classList.toggle('on', on);
    $('auth-chip-text').textContent = on ? 'Sudah masuk' : 'Belum masuk';
    $('auth-chip').querySelector('.material-symbols-outlined').textContent = on ? 'lock_open' : 'lock';
  }
  refreshAuth(); document.addEventListener('wb:auth-change', refreshAuth);

  const modal = $('modal-login'); let pending = null;
  const openLogin = (type) => {
    pending = type || null;
    $('modal-sub').textContent = type ? 'Masuk dulu untuk mengunduh ' + type.toUpperCase() : 'Masuk untuk mengunduh keepsake kamu';
    modal.classList.remove('hidden');
  };
  const closeLogin = () => modal.classList.add('hidden');
  document.querySelectorAll('[data-open-login]').forEach(b => b.addEventListener('click', () => openLogin(null)));
  $('modal-login-close').addEventListener('click', closeLogin);
  modal.addEventListener('click', e => { if (e.target === modal) closeLogin(); });
  document.addEventListener('wb:login-success', () => {
    toast('Berhasil masuk! ✨', 'check_circle');
    if (pending) { const t = pending; pending = null; setTimeout(() => download(t), 600); }
  });

  // ---------- render file ----------
  function loadImg(src) { return WBTpl.loadImg(src); }
  function cover(ctx, im, x, y, w, h) { WBTpl.cover(ctx, im, x, y, w, h); }
  async function renderStrip(kind, mime) {
    const c = await WBTpl.render(tpl, strip.images, { width: WBTpl.outputSize(tpl, kind).w, bg: strip.bg });
    return new Promise((res, rej) => c.toBlob(b => b ? res(b) : rej(new Error('blob')), mime, 0.88));
  }
  async function renderGif() {
    const imgs = await Promise.all(strip.images.map(loadImg));
    const f = tpl.slots[0], w = 400, h = Math.max(2, Math.round(w * f.h / f.w)), frames = imgs.map(im => {
      const c = document.createElement('canvas'); c.width = w; c.height = h;
      const ctx = c.getContext('2d'); cover(ctx, im, 0, 0, w, h);
      return { data: ctx.getImageData(0, 0, w, h).data, w, h };
    });
    return new Blob([WBGif.encode(frames, 32)], { type: 'image/gif' });
  }
  function save(blob, name) {
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = name;
    document.body.appendChild(a); a.click(); a.remove(); setTimeout(() => URL.revokeObjectURL(a.href), 4000);
  }
  async function download(type) {
    if (!(await WBAuth.check())) { openLogin(type); return; } // wajib login
    const btn = document.querySelector('.download-action-btn[data-type="' + type + '"]');
    btn?.classList.add('busy'); toast('Menyiapkan ' + type.toUpperCase() + '…', 'hourglass_top');
    try {
      const stamp = Date.now();
      if (type === 'png') save(await renderStrip('png', 'image/png'), 'whimshy-strip-' + stamp + '.png');
      else if (type === 'jpg') save(await renderStrip('jpg', 'image/jpeg'), 'whimshy-strip-' + stamp + '.jpg');
      else save(await renderGif(), 'whimshy-strip-' + stamp + '.gif');
      toast(type.toUpperCase() + ' tersimpan ke perangkatmu ✨', 'check_circle');
    } catch (e) {
      toast('Gagal menyiapkan file (gambar tidak bisa diakses)', 'error');
    }
    btn?.classList.remove('busy');
  }
  document.querySelectorAll('.download-action-btn').forEach(b => b.addEventListener('click', () => download(b.dataset.type)));

  // ---------- GIF preview ----------
  let gifOn = false, gifTimer = null, gi = 0;
  $('toggle-gif').addEventListener('click', () => {
    gifOn = !gifOn;
    $('gif-layer').classList.toggle('hidden', !gifOn);
    $('gif-label').textContent = gifOn ? 'Jeda animasi GIF' : 'Putar animasi GIF';
    $('toggle-gif').querySelector('.material-symbols-outlined').textContent = gifOn ? 'pause_circle' : 'play_circle';
    clearInterval(gifTimer);
    if (gifOn) { $('gif-target').src = strip.images[gi]; gifTimer = setInterval(() => { gi = (gi + 1) % N; $('gif-target').src = strip.images[gi]; }, 320); }
  });

  // ---------- zoom ----------
  const zm = $('modal-zoom');
  $('open-zoom').addEventListener('click', async () => {
    try { $('zoom-img').src = URL.createObjectURL(await renderStrip('zoom', 'image/jpeg')); zm.classList.remove('hidden'); }
    catch (e) { toast('Pratinjau besar tidak tersedia', 'error'); }
  });
  $('modal-zoom-close').addEventListener('click', () => zm.classList.add('hidden'));
  zm.addEventListener('click', e => { if (e.target === zm) zm.classList.add('hidden'); });

  // ---------- share ----------
  $('copy-link').addEventListener('click', async () => {
    try { await navigator.clipboard.writeText($('share-link').value); toast('Tautan disalin!', 'content_copy'); }
    catch (e) { $('share-link').select(); toast('Pilih dan salin tautannya', 'content_copy'); }
  });
  $('web-share').addEventListener('click', async () => {
    const url = location.href;
    if (navigator.share) { try { await navigator.share({ title: 'WHIMSHYBOOTH', text: 'Lihat momen photobooth ajaibku!', url }); } catch (e) {} }
    else { try { await navigator.clipboard.writeText(url); toast('Tautan disalin!', 'content_copy'); } catch (e) { toast('Share tidak didukung', 'error'); } }
  });

  document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeLogin(); zm.classList.add('hidden'); } });
});
