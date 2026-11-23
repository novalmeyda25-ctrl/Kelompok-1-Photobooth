(function () {
  console.log('wb-auth.js v3 loaded');
  const cfg = window.WB_AUTH || {};
  cfg.urls = cfg.urls || {};

  const state = {
    loggedIn: !!cfg.logged_in,
    user: cfg.user || null
  };

  let csrf = cfg.csrf ||
    (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

  const F = Object.assign({
    email: 'email',
    password: 'password',
    name: 'name',
    confirm: 'password_confirmation'
  }, cfg.fields || {});

  // =========================
  // REQUEST LARAVEL
  // =========================

  async function api(method, url, body) {
    if (!url) throw new Error('Endpoint belum dikonfigurasi.');

    let res;

    try {
      res = await fetch(url, {
        method: method,
        credentials: 'same-origin',
        redirect: 'manual',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: body ? JSON.stringify(body) : undefined
      });
    } catch (e) {
      throw new Error('Tidak bisa terhubung ke server.');
    }

    if (res.type === 'opaqueredirect') {
      return { redirected: true };
    }

    let data = null;
    try {
      data = await res.json();
    } catch (e) {}

    if (!res.ok) {
      let msg = (data && data.message) || 'Terjadi kesalahan.';

      if (data && data.errors) {
        const first = Object.values(data.errors)[0];
        msg = (first && first[0]) || msg;
      }

      if (res.status === 419)
        msg = 'Sesi halaman habis. Muat ulang halaman.';

      if (res.status === 429)
        msg = 'Terlalu banyak percobaan. Tunggu sebentar.';

      throw new Error(msg);
    }

    return data || {};
  }

  // =========================
  // CEK STATUS LOGIN
  // =========================

  async function pageState() {
    try {
      const r = await fetch(location.href, {
        credentials: 'same-origin',
        cache: 'no-store',
        headers: {
          'Accept': 'text/html'
        }
      });

      const t = await r.text();
      const m = t.match(/logged_in:\s*(true|false)/);

      if (!m) return null;

      let user = null;

      const u = t.match(/\n\s*user:\s*(\{[^\n]*\}|null),/);

      if (u) {
        try {
          user = JSON.parse(u[1]);
        } catch (e) {}
      }

      const c = t.match(/csrf:\s*"([^"]+)"/);

      return {
        logged_in: m[1] === 'true',
        user: user,
        csrf: c && c[1]
      };
    } catch (e) {
      return null;
    }
  }

  function apply(d) {
    if (d && d.csrf) {
      csrf = d.csrf;

      const m = document.querySelector('meta[name="csrf-token"]');

      if (m) m.content = csrf;
    }

    state.loggedIn = !!(d && d.logged_in);
    state.user = (d && d.user) || null;

    document.dispatchEvent(
      new CustomEvent('wb:auth-change', {
        detail: state
      })
    );

    return state.loggedIn;
  }

  async function afterAuth(fallbackUser) {
    const s = await pageState();

    if (s && !s.logged_in) {
      throw new Error(
        'Belum berhasil masuk. Cek email dan kata sandi.'
      );
    }

    return apply(s || {
      logged_in: true,
      user: fallbackUser
    });
  }

  // =========================
  // WB AUTH
  // =========================

  window.WBAuth = {
    isLoggedIn: function () {
      return state.loggedIn;
    },

    user: function () {
      return state.user;
    },

    check: async function () {
      if (cfg.urls.me) {
        try {
          const d = await api('GET', cfg.urls.me);

          return apply({
            logged_in: d.logged_in !== undefined
              ? d.logged_in
              : !!d.user,
            user: d.user,
            csrf: d.csrf
          });
        } catch (e) {
          return false;
        }
      }

      const s = await pageState();

      return s ? apply(s) : state.loggedIn;
    },

    login: async function (email, password) {
      const b = {};

      b[F.email] = email;
      b[F.password] = password;
      b.remember = true;

      await api('POST', cfg.urls.login, b);

      return afterAuth({
        name: '',
        email: email
      });
    },

    register: async function (name, email, password) {
      const b = {};

      b[F.name] = name;
      b[F.email] = email;
      b[F.password] = password;
      b[F.confirm] = password;

      await api('POST', cfg.urls.register, b);

      return afterAuth({
        name: name,
        email: email
      });
    },

    // LUPA SANDI
    forgot: async function (email) {
      const b = {};

      b[F.email] = email;

      await api('POST', cfg.urls.forgot || '/forgot-password', b);

      return true;
    },

    // GOOGLE LOGIN
    google: function () {
      if (!cfg.urls.google) {
        notify('Login Google belum dikonfigurasi.');
        return;
      }

      try {
        const url = new URL(
          cfg.urls.google,
          window.location.origin
        );

        url.searchParams.set(
          'redirect',
          location.href
        );

        window.location.assign(url.toString());

      } catch (e) {
        notify('Alamat Login Google tidak valid.');
      }
    },

    logout: async function () {
      try {
        await api('POST', cfg.urls.logout);
      } finally {
        window.location.reload();
      }
    }
  };

  // =========================
  // STYLE
  // =========================

  const CSS = `
    .wbx-tabs {
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:5px;
      padding:4px;
      margin:0 0 14px;
      background:#FFF0F5;
      border:1px solid #FBCFE8;
      border-radius:999px;
    }
      

    .wbx-tab {
      border:0;
      background:transparent;
      border-radius:999px;
      padding:9px 10px;
      font-family:inherit;
      font-size:13px;
      font-weight:600;
      color:#946778;
      cursor:pointer;
      transition:all .25s;
    }

    .wbx-tab[aria-selected="true"] {
      background:#BE185D;
      color:white;
      box-shadow:0 4px 12px rgba(190,24,93,.2);
    }

    .wbx-div {
      display:flex;
      align-items:center;
      gap:10px;
      margin:12px 0;
      color:#9D7B89;
      font-size:11px;
    }

    .wbx-div::before,
    .wbx-div::after {
      content:"";
      flex:1;
      border-top:1px solid #FBCFE8;
    }

    .wbx-google {
      width:100%;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:10px;
      padding:10px;
      border-radius:999px;
      border:1px solid #F2D5E2;
      background:white;
      color:#5C4550;
      font-family:inherit;
      font-size:13px;
      font-weight:600;
      cursor:pointer;
      transition:all .2s;
    }

    .wbx-google:hover {
      background:#FFF5F8;
      border-color:#BE185D;
    }

    .wbx-google:disabled {
      opacity:.6;
      cursor:wait;
    }

    .wbx-card {
      position:fixed;
      z-index:2147483000;
      width:292px;
      max-width:calc(100vw - 24px);
      background:white;
      border:1px solid #FBCFE8;
      border-radius:22px;
      padding:18px;
      box-shadow:0 18px 50px rgba(151,0,70,.22);
      animation:wbxIn .18s ease-out;
    }

    @keyframes wbxIn {
      from {
        opacity:0;
        transform:translateY(-6px) scale(.98);
      }
      to {
        opacity:1;
        transform:none;
      }
    }

    .wbx-row {
      display:flex;
      align-items:center;
      gap:12px;
    }

    .wbx-av {
      flex:none;
      width:46px;
      height:46px;
      border-radius:50%;
      display:grid;
      place-items:center;
      background:linear-gradient(135deg,#BE185D,#F472B6);
      color:white;
      font:700 19px serif;
      box-shadow:0 4px 14px rgba(190,24,93,.35);
    }

    .wbx-name {
      font-weight:700;
      font-size:15px;
      color:#970046;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:nowrap;
    }

    .wbx-mail {
      font-size:12px;
      color:#8D7075;
      overflow:hidden;
      text-overflow:ellipsis;
      white-space:nowrap;
    }

    .wbx-ok {
      display:inline-flex;
      margin:14px 0 4px;
      padding:5px 10px;
      border-radius:999px;
      background:#ECFDF5;
      color:#047857;
      font-size:11px;
      font-weight:700;
    }

    .wbx-out {
      width:100%;
      margin-top:10px;
      padding:11px;
      border-radius:999px;
      border:1px solid #FBCFE8;
      background:white;
      color:#BE185D;
      font-weight:700;
      cursor:pointer;
      transition:all .2s;
    }

    .wbx-out:hover {
      background:#BE185D;
      color:white;
    }

    .wbx-out:disabled {
      opacity:.6;
      cursor:wait;
    }

    .wbx-note {
      position:fixed;
      left:50%;
      bottom:26px;
      transform:translateX(-50%);
      z-index:2147483001;
      background:#970046;
      color:white;
      padding:11px 18px;
      border-radius:999px;
      font-family:inherit;
      font-size:13px;
      font-weight:600;
      box-shadow:0 10px 30px rgba(151,0,70,.35);
      animation:wbxIn .2s;
    }

    .wbx-forgot {
  display:block;
  text-align:right;
  font-size:12px;
  font-weight:600;
  margin:6px 6px 10px;
  color:#BE185D;
  text-decoration:none;
  cursor:pointer;
}

.wbx-forgot:hover {
  text-decoration:underline;
}

    #wb-auth-error {
      color:#BE123C;
      font-size:12.5px;
      margin:8px 0;
      min-height:0;
    }

    #wb-auth-error:empty {
      display:none;
    }

    /* Batasi tinggi modal supaya tidak kepanjangan */
    .wbx-shell {
      zoom:.85;
      max-width:460px;
      max-height:calc((100vh - 24px) / .7);
    }

    #modal-login,
    #modal-login * {
      scrollbar-width:none !important;
      -ms-overflow-style:none !important;
    }

    #modal-login::-webkit-scrollbar,
    #modal-login *::-webkit-scrollbar {
      display:none !important;
      width:0 !important;
      height:0 !important;
    }

    #modal-login h3 {
      font-size:clamp(18px, 4.5vw, 22px);
      line-height:1.2;
      margin-bottom:4px;
    }

    #modal-login form input {
      padding-top:9px;
      padding-bottom:9px;
    }

    #modal-login form label {
      margin-bottom:3px;
    }

    #modal-login form > div,
    #modal-login form .field {
      margin-bottom:10px;
    }

    #modal-login form button[type=submit] {
      padding-top:10px;
      padding-bottom:10px;
      margin-top:6px;
    }
  `;

  const st = document.createElement('style');

  st.textContent = CSS;

  document.head.appendChild(st);

  // =========================
  // GOOGLE ICON
  // =========================

  const G =
    '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">' +
    '<path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.4l3.7 2.9C6.5 7.4 9 5 12 5z"/>' +
    '<path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5.1 3.7-8.8z"/>' +
    '<path fill="#FBBC05" d="M5.6 14.7c-.2-.7-.4-1.5-.4-2.7s.1-2 .4-2.7L1.9 6.4C.7 8.8 0 10.8 0 12s.7 3.2 1.9 5.6l3.7-2.9z"/>' +
    '<path fill="#34A853" d="M12 23c3.2 0 5.9-1.1 7.8-2.9l-3.7-2.9c-1 .7-2.4 1.1-4.1 1.1-3 0-5.5-2-6.4-4.7l-3.7 2.9C3.7 20.4 7.5 23 12 23z"/>' +
    '</svg>';

  // =========================
  // UTILITAS
  // =========================

  const esc = function (t) {
    const d = document.createElement('div');

    d.textContent = t == null ? '' : String(t);

    return d.innerHTML;
  };

  const display = function () {
    const u = state.user || {};

    return u.name ||
      (u.email ? u.email.split('@')[0] : 'Akun');
  };

  function notify(msg) {
    if (document.getElementById('toast')) return;

    const old = document.querySelector('.wbx-note');

    if (old) old.remove();

    const n = document.createElement('div');

    n.className = 'wbx-note';
    n.textContent = msg;

    document.body.appendChild(n);

    setTimeout(function () {
      n.remove();
    }, 2800);
  }

  // =========================
  // DOM
  // =========================

  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');
    const modal = document.getElementById('modal-login');
    const loginBtn = document.getElementById('nav-login-btn');
    const profBtn = document.getElementById('nav-profile-btn');
    const chip = document.getElementById('auth-chip');

    // =========================
    // KARTU PROFIL
    // =========================

    let card = null;
    let anchor = null;

    function closeCard() {
      if (card) {
        card.remove();
        card = null;
      }
    }

    function openCard(el) {
      closeCard();

      anchor = el;

      const u = state.user || {};
      const name = display();

      card = document.createElement('div');

      card.className = 'wbx-card';
      card.setAttribute('role', 'dialog');

      card.innerHTML =
        '<div class="wbx-row">' +
          '<div class="wbx-av">' +
            esc(name.charAt(0).toUpperCase()) +
          '</div>' +
          '<div style="min-width:0">' +
            '<div class="wbx-name">' +
              esc(name) +
            '</div>' +
            '<div class="wbx-mail">' +
              esc(u.email || '') +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="wbx-ok">● Sudah masuk</div>' +
        '<button type="button" class="wbx-out">Keluar</button>';

      document.body.appendChild(card);

      const r = el.getBoundingClientRect();

      card.style.top = Math.round(r.bottom + 10) + 'px';

      card.style.right = Math.max(
        12,
        Math.round(window.innerWidth - r.right)
      ) + 'px';

      card.querySelector('.wbx-out').addEventListener(
        'click',
        async function () {
          this.disabled = true;
          this.textContent = 'Keluar…';

          try {
            await WBAuth.logout();
          } catch (e) {
            this.disabled = false;
            this.textContent = 'Keluar';
            notify(e.message);
          }
        }
      );
    }

    document.addEventListener('click', function (e) {
      if (
        card &&
        !card.contains(e.target) &&
        !(anchor && anchor.contains(e.target))
      ) {
        closeCard();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeCard();
    });

    window.addEventListener('resize', closeCard);

    [profBtn, chip].filter(Boolean).forEach(function (b) {
      b.style.cursor = 'pointer';

      b.addEventListener('click', function (e) {
        if (!state.loggedIn) return;

        e.stopImmediatePropagation();
        e.preventDefault();

        card && anchor === b
          ? closeCard()
          : openCard(b);
      }, true);
    });

    // =========================
    // NAVBAR
    // =========================

    function syncNav() {
      if (loginBtn) {
        loginBtn.style.display = state.loggedIn
          ? 'none'
          : '';
      }

      if (profBtn) {
        const icon = profBtn.querySelector(
          '.material-symbols-outlined'
        );

        let ini = profBtn.querySelector('.wbx-ini');

        if (state.loggedIn) {
          if (!ini) {
            ini = document.createElement('span');
            ini.className = 'wbx-ini';
            ini.style.cssText = 'font:700 15px serif';
            profBtn.appendChild(ini);
          }

          ini.textContent = display().charAt(0).toUpperCase();
          ini.style.display = '';

          if (icon) icon.style.display = 'none';

          profBtn.setAttribute(
            'title',
            (state.user && state.user.email) || ''
          );

        } else {
          if (ini) ini.style.display = 'none';

          if (icon) icon.style.display = '';

          profBtn.removeAttribute('title');
        }
      }

      if (!state.loggedIn) closeCard();
    }

    document.addEventListener('wb:auth-change', syncNav);

    syncNav();

    // =========================
    // MODAL
    // =========================

    if (!form) return;

    const email = form.querySelector('input[type=email]');
    const pass = form.querySelector('input[type=password]');
    const submit = form.querySelector('button[type=submit]');

    if (!email || !pass || !submit) return;

    form.removeAttribute('onsubmit');

    // Tandai kartu modal (anak langsung #modal-login yang berisi form)
    if (modal) {
      let shell = form;

      while (shell.parentElement && shell.parentElement !== modal) {
        shell = shell.parentElement;
      }

      if (shell.parentElement === modal) {
        shell.classList.add('wbx-shell');
      }

      // Paksa tanpa scroll bar di semua pembungkus form sampai modal
      let n = form;

      while (n && n !== document.body) {
        n.style.setProperty('overflow', 'hidden', 'important');
        n.style.setProperty('scrollbar-width', 'none', 'important');

        if (n === modal) break;

        n = n.parentElement;
      }

      shell.style.setProperty('max-height', 'none', 'important');
      shell.style.setProperty('overflow', 'visible', 'important');
      modal.style.setProperty('overflow', 'hidden', 'important');
    }

    // =========================
    // BERSIHKAN TAB LAMA
    // =========================

    if (modal) {
      modal.querySelectorAll('.wbx-tabs').forEach(function (x) {
        x.remove();
      });

      modal.querySelectorAll('button').forEach(function (btn) {
        if (!/^(Masuk|Daftar)$/i.test(btn.textContent.trim())) {
          return;
        }

        const parent = btn.parentElement;

        if (
          parent &&
          parent.querySelectorAll('button').length >= 2 &&
          Array.from(parent.querySelectorAll('button')).some(
            b => /^Masuk$/i.test(b.textContent.trim())
          ) &&
          Array.from(parent.querySelectorAll('button')).some(
            b => /^Daftar$/i.test(b.textContent.trim())
          )
        ) {
          parent.remove();
        }
      });

      modal.querySelectorAll(
        '[data-social], button[onclick*="WBAuth.login("]'
      ).forEach(function (b) {
        b.remove();
      });

      modal.querySelectorAll(
        '.social-row, .divider'
      ).forEach(function (x) {
        x.remove();
      });

      modal.querySelectorAll('div').forEach(function (d) {
        if (
          d.children.length === 0 &&
          /grid/.test(d.className)
        ) {
          d.remove();
        } else if (
          d.textContent.trim() === 'Atau lanjutkan dengan'
        ) {
          d.remove();
        }
      });
    }

    // =========================
    // KOLOM NAMA
    // =========================

    if (!document.getElementById('wb-name-wrap')) {
      const wrap = document.createElement('div');

      wrap.id = 'wb-name-wrap';
      wrap.className = 'hidden';

      const field = email.parentElement;
      const isField = field.classList.contains('field');
      const block = isField ? null : field.parentElement;

      if (isField) {
        wrap.appendChild(
          field.previousElementSibling.cloneNode(true)
        );

        wrap.appendChild(field.cloneNode(true));

        field.previousElementSibling.parentNode.insertBefore(
          wrap,
          field.previousElementSibling
        );

      } else {
        wrap.appendChild(block.cloneNode(true));

        block.parentNode.insertBefore(wrap, block);
      }

      const inp = wrap.querySelector('input');

      inp.type = 'text';
      inp.removeAttribute('id');
      inp.value = '';
      inp.required = false;
      inp.placeholder = 'Nama kamu';
      inp.maxLength = 80;

      const lab = wrap.querySelector('label');

      if (lab) lab.textContent = 'Nama';

      const ic = wrap.querySelector(
        '.material-symbols-outlined'
      );

      if (ic) ic.textContent = 'person';
    }

    // =========================
    // ERROR
    // =========================

    if (!document.getElementById('wb-auth-error')) {
      const p = document.createElement('p');

      p.id = 'wb-auth-error';
      p.setAttribute('role', 'alert');

      submit.parentNode.insertBefore(p, submit);
    }

    const nameWrap = document.getElementById('wb-name-wrap');
    const nameIn = nameWrap && nameWrap.querySelector('input');
    const err = document.getElementById('wb-auth-error');

    const loginText = submit.textContent.trim();

    const title = modal && modal.querySelector('h3');
    const titleText = title ? title.textContent : '';

    // =========================
    // TAB MASUK / DAFTAR
    // =========================

    const tabs = document.createElement('div');

    tabs.className = 'wbx-tabs';
    tabs.setAttribute('role', 'tablist');

    tabs.innerHTML =
      '<button type="button" class="wbx-tab" data-m="login" role="tab">' +
        'Masuk' +
      '</button>' +
      '<button type="button" class="wbx-tab" data-m="register" role="tab">' +
        'Daftar' +
      '</button>';

    form.parentNode.insertBefore(tabs, form);

    // =========================
    // LUPA SANDI (hanya satu)
    // =========================

    const links = Array.from((modal || form).querySelectorAll('a'))
      .filter(function (a) {
        return /lupa/i.test(a.textContent);
      });

    let forgot = links[0];

    links.slice(1).forEach(function (a) {
      a.remove();
    });

    if (!forgot) {
  forgot = document.createElement('a');
  forgot.className = 'wbx-forgot';
  forgot.textContent = 'Lupa Sandi?';
  // Taruh di LUAR kotak input supaya ikon gembok tidak bergeser
  pass.parentElement.insertAdjacentElement('afterend', forgot);
}

    forgot.removeAttribute('onclick');
    forgot.href = '#';

    forgot.addEventListener('click', function (e) {
      e.preventDefault();
      setMode('forgot');
    });

    // Elemen kolom sandi (label + input), disembunyikan di mode "forgot"
    const pWrap = pass.parentElement;

    const passEls = pWrap.classList.contains('field')
      ? [pWrap.previousElementSibling, pWrap]
      : (pWrap.parentElement && pWrap.parentElement !== form
          ? [pWrap.parentElement]
          : [pWrap]);

    // =========================
    // GANTI MODE
    // =========================

    let mode = 'login';

    function setMode(m) {
      mode = m;

      tabs.querySelectorAll('.wbx-tab').forEach(function (t) {
        t.setAttribute(
          'aria-selected',
          String(t.dataset.m === m)
        );
      });

      if (nameWrap) {
        nameWrap.classList.toggle('hidden', m !== 'register');
      }

      if (nameIn) {
        nameIn.required = m === 'register';
      }

      passEls.forEach(function (el) {
        if (el) el.style.display = m === 'forgot' ? 'none' : '';
      });

      pass.required = m !== 'forgot';

      pass.autocomplete = m === 'register'
        ? 'new-password'
        : 'current-password';

      if (m === 'register') {
        pass.setAttribute('minlength', '8');
      } else {
        pass.removeAttribute('minlength');
      }

      submit.textContent = m === 'register'
        ? 'Daftar & Masuk'
        : m === 'forgot'
          ? 'Kirim Tautan Reset'
          : loginText;

      if (title) {
        title.textContent = m === 'register'
          ? titleText.replace(/^Masuk/, 'Daftar')
          : m === 'forgot'
            ? 'Lupa Kata Sandi'
            : titleText;
      }

      // Link "Lupa Sandi?" hanya tampil di mode login
      forgot.style.display = m === 'login' ? '' : 'none';

      if (err) {
        err.textContent = '';
        err.style.color = '';
      }
    }

    tabs.addEventListener('click', function (e) {
      const t = e.target.closest('.wbx-tab');

      if (t) setMode(t.dataset.m);
    });

    setMode('login');

    // =========================
    // GOOGLE BUTTON
    // =========================

    if (cfg.urls.google) {
      const box = document.createElement('div');

      box.innerHTML =
        '<div class="wbx-div">Atau</div>' +
        '<button type="button" class="wbx-google">' +
          G +
          '<span>Lanjutkan dengan Google</span>' +
        '</button>';

      form.parentNode.insertBefore(
        box,
        form.nextSibling
      );

      const googleBtn = box.querySelector('.wbx-google');

      googleBtn.addEventListener('click', function () {
        googleBtn.disabled = true;

        googleBtn.querySelector('span').textContent =
          'Menghubungkan ke Google…';

        try {
          WBAuth.google();
        } catch (e) {
          googleBtn.disabled = false;

          googleBtn.querySelector('span').textContent =
            'Lanjutkan dengan Google';

          notify(e.message);
        }
      });

      // Reset tombol kalau user kembali (Back) dari halaman Google
      window.addEventListener('pageshow', function () {
        googleBtn.disabled = false;

        googleBtn.querySelector('span').textContent =
          'Lanjutkan dengan Google';
      });
    }

    // =========================
    // SUBMIT FORM
    // =========================

    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      if (err) {
        err.textContent = '';
        err.style.color = '';
      }

      if (
        mode === 'register' &&
        pass.value.length < 8
      ) {
        if (err) {
          err.textContent =
            'Kata sandi minimal 8 karakter.';
        }

        return;
      }

      submit.disabled = true;

      const label = submit.textContent;

      submit.textContent = 'Memproses…';

      try {
        if (mode === 'forgot') {
          await WBAuth.forgot(email.value.trim());

          if (err) {
            err.style.color = '#047857';
            err.textContent =
              'Tautan reset dikirim. Cek email kamu.';
          }
        } else {
          if (mode === 'register') {
            await WBAuth.register(
              nameIn.value.trim(),
              email.value.trim(),
              pass.value
            );
          } else {
            await WBAuth.login(
              email.value.trim(),
              pass.value
            );
          }

          form.reset();

          // Cek admin: /dashboard otomatis mengarahkan admin ke /admin/dashboard
try {
  const r = await fetch('/dashboard', {
    credentials: 'same-origin',
    cache: 'no-store',
    headers: { 'Accept': 'text/html' }
  });

  if (r.redirected && /\/admin(\/|$)/.test(new URL(r.url).pathname)) {
    window.location.assign(r.url);
    return;
  }
} catch (e) {}

          if (modal) {
            modal.classList.add('hidden');
          }

          notify(
            'Selamat datang, ' + display() + '! ✨'
          );

          document.dispatchEvent(
            new CustomEvent('wb:login-success')
          );
        }

      } catch (ex) {
        if (err) {
          err.style.color = '';
          err.textContent = ex.message;
        } else {
          alert(ex.message);
        }
      }

      submit.disabled = false;
      submit.textContent = label;
    });
  });
})();
