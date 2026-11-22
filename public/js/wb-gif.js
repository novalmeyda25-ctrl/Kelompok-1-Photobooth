// public/js/wb-gif.js — encoder GIF kecil (tanpa library)
(function (root) {
  const BAYER = [0, 8, 2, 10, 12, 4, 14, 6, 3, 11, 1, 9, 15, 7, 13, 5];

  function quantize(rgba, w, h) {
    const out = new Uint8Array(w * h);
    for (let y = 0, i = 0; y < h; y++) {
      for (let x = 0; x < w; x++, i++) {
        const th = (BAYER[(y & 3) * 4 + (x & 3)] / 16 - 0.5) * 36, p = i * 4;
        const r = Math.min(255, Math.max(0, rgba[p] + th));
        const g = Math.min(255, Math.max(0, rgba[p + 1] + th));
        const b = Math.min(255, Math.max(0, rgba[p + 2] + th * 1.6));
        out[i] = ((r >> 5) << 5) | ((g >> 5) << 2) | (b >> 6);
      }
    }
    return out;
  }

  function lzw(idx, minCode) {
    const clear = 1 << minCode, eoi = clear + 1;
    let size = minCode + 1, next = eoi + 1, cur = 0, bits = 0;
    const bytes = [], dict = new Map();
    const emit = (c) => { cur |= c << bits; bits += size; while (bits >= 8) { bytes.push(cur & 255); cur >>>= 8; bits -= 8; } };
    emit(clear);
    let prefix = idx[0];
    for (let i = 1; i < idx.length; i++) {
      const k = idx[i], key = prefix * 256 + k, v = dict.get(key);
      if (v !== undefined) { prefix = v; continue; }
      emit(prefix);
      if (next < 4096) {
        dict.set(key, next++);
        if (next - 1 > (1 << size) - 1 + 0 && size < 12) size++;
      } else { emit(clear); dict.clear(); size = minCode + 1; next = eoi + 1; }
      prefix = k;
    }
    emit(prefix); emit(eoi);
    if (bits > 0) bytes.push(cur & 255);
    return bytes;
  }

  // frames: [{data: Uint8ClampedArray(RGBA), w, h}], delay dalam 1/100 detik
  function encode(frames, delay) {
    const w = frames[0].w, h = frames[0].h, o = [];
    const u16 = (n) => o.push(n & 255, (n >> 8) & 255);
    'GIF89a'.split('').forEach((c) => o.push(c.charCodeAt(0)));
    u16(w); u16(h); o.push(0xF7, 0, 0);
    for (let i = 0; i < 256; i++) o.push(Math.round(((i >> 5) & 7) * 255 / 7), Math.round(((i >> 2) & 7) * 255 / 7), Math.round((i & 3) * 255 / 3));
    o.push(0x21, 0xFF, 11); 'NETSCAPE2.0'.split('').forEach((c) => o.push(c.charCodeAt(0))); o.push(3, 1, 0, 0, 0);
    frames.forEach((f) => {
      o.push(0x21, 0xF9, 4, 0, delay & 255, (delay >> 8) & 255, 0, 0);
      o.push(0x2C); u16(0); u16(0); u16(w); u16(h); o.push(0);
      o.push(8);
      const data = lzw(quantize(f.data, w, h), 8);
      for (let i = 0; i < data.length; i += 255) { const n = Math.min(255, data.length - i); o.push(n); for (let j = 0; j < n; j++) o.push(data[i + j]); }
      o.push(0);
    });
    o.push(0x3B);
    return new Uint8Array(o);
  }

  root.WBGif = { encode };
  if (typeof module !== 'undefined') module.exports = root.WBGif;
})(typeof window !== 'undefined' ? window : globalThis);
