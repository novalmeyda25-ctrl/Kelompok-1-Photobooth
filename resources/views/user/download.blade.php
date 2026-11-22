{{-- resources/views/user/download.blade.php --}}
<!doctype html>
<html lang="id" class="dl-arriving">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WHIMSYBOOTH — Fairy Keepsake</title>

    <script>
        try {
            if (sessionStorage.getItem('wb_arrive_dl') === '1') {
                sessionStorage.removeItem('wb_arrive_dl');
            } else {
                document.documentElement.classList.remove('dl-arriving');
            }
        } catch (e) {
            document.documentElement.classList.remove('dl-arriving');
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/whimsybooth/fairy-logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/download.css') }}">
</head>

<body>

@php $home = url('/home'); @endphp

<div class="ambient a1"></div>
<div class="ambient a2"></div>
<div class="ambient a3"></div>

<main class="page">

    <div class="topline">
        <a class="back-pill" href="{{ $home }}">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Home
        </a>

        <a class="brand" href="{{ $home }}">
            <img class="brand-logo" src="{{ asset('images/whimsybooth/fairy-logo.png') }}" alt="Whimsybooth fairy logo">
            <span class="brand-name">WHIMSYBOOTH</span>
            <span class="brand-tag">Fairy Magic</span>
        </a>

        <span class="status-chip" id="auth-chip">
            <span class="material-symbols-outlined">lock</span>
            <span id="auth-chip-text">Belum masuk</span>
        </span>
    </div>

    <div class="showcase">

        {{-- KIRI: strip --}}
        <section class="left-panel">

            <div class="polaroid" id="strip-card">
                <div class="frame-heading">
                    <strong>✿ WHIMSYBOOTH ✿</strong>
                    <small id="strip-theme">FAIRY GARDEN</small>
                </div>

                <div class="frames" id="frames-container">
                    <div id="gif-layer" class="gif-layer hidden">
                        <img id="gif-target" src="" alt="Pratinjau GIF">
                        <span class="loop-tag">● LOOP</span>
                    </div>
                </div>

                <div class="strip-meta">
                    <div>
                        <strong>Whimsical Bloom Strip</strong>
                        <small id="strip-date"></small>
                    </div>
                    <span class="seal">❀</span>
                </div>
            </div>

            <div class="player-controls">
                <button id="toggle-gif" type="button">
                    <span class="material-symbols-outlined">play_circle</span>
                    <span id="gif-label">Putar animasi GIF</span>
                </button>

                <button id="open-zoom" type="button" title="Perbesar">
                    <span class="material-symbols-outlined">zoom_in</span>
                </button>
            </div>

        </section>

        {{-- KANAN --}}
        <section class="right-panel">

            <div class="intro">
                <span class="completion-pill">
                    <span class="material-symbols-outlined">verified</span>
                    Sesi foto selesai
                </span>

                <h1>Keepsake Fairy kamu <em>sudah siap</em></h1>

                <p>
                    Unduh strip foto atau GIF animasi untuk disimpan di buku kenangan ajaibmu.
                    Masuk dulu ya, supaya file resolusi tinggi bisa diunduh.
                </p>

                <div class="specs">
                    <span>
                        <span class="material-symbols-outlined">grid_view</span>
                        Template <b id="spec-template">Classic Strip</b>
                    </span>

                    <span>
                        <span class="material-symbols-outlined">palette</span>
                        Frame <b id="spec-frame">Garden</b>
                    </span>
                </div>
            </div>

            <div class="visitor-card" id="visitor-card">
                <div class="visitor-text">
                    <span class="material-symbols-outlined">lock</span>

                    <div>
                        <strong>Login diperlukan untuk download</strong>
                        <p>
                            Kamu masih bisa melihat pratinjau.
                            Untuk mengunduh PNG, JPG, atau GIF, masuk dulu.
                        </p>
                    </div>
                </div>

                <button type="button" class="btn-primary" data-open-login>
                    Masuk Sekarang
                </button>
            </div>

            <section class="downloads">

                <div class="section-heading">
                    <strong>Pilih format download</strong>
                    <small>Siap cetak 300 DPI</small>
                </div>

                <div class="download-grid">

                    <article class="download-card">
                        <span class="tag pink">Lossless Print</span>
                        <h3>High-Res PNG</h3>
                        <p id="png-desc">
                            Kualitas penuh tanpa kompresi, ideal untuk dicetak.
                        </p>

                        <button class="download-action-btn" data-type="png" type="button">
                            <span class="material-symbols-outlined">download</span>
                            Download PNG
                        </button>
                    </article>

                    <article class="download-card">
                        <span class="tag rose">Web &amp; Mobile</span>
                        <h3>Compact JPG</h3>
                        <p>
                            Ringan untuk wallpaper HP, story WhatsApp, dan dibagikan cepat.
                        </p>

                        <button class="download-action-btn" data-type="jpg" type="button">
                            <span class="material-symbols-outlined">download</span>
                            Download JPG
                        </button>
                    </article>

                    <article class="download-card">
                        <span class="tag lavender">Moving Poses</span>
                        <h3>Animated GIF</h3>
                        <p>
                            Semua pose berputar dalam satu animasi loop yang menggemaskan.
                        </p>

                        <button class="download-action-btn" data-type="gif" type="button">
                            <span class="material-symbols-outlined">play_arrow</span>
                            Download GIF
                        </button>
                    </article>

                </div>
            </section>

            <section class="share-card">

                <div class="share-heading">
                    <div>
                        <strong>Bagikan keajaibannya</strong>
                        <p>Salin tautan atau bagikan langsung dari perangkatmu.</p>
                    </div>

                    <button id="web-share" type="button">
                        <span class="material-symbols-outlined">ios_share</span>
                        Share
                    </button>
                </div>

                <div class="copy-field">
                    <input id="share-link" readonly value="">
                    <button id="copy-link" type="button">Salin</button>
                </div>

            </section>

            <div class="next-actions">
                <a href="{{ $home }}" class="retake">
                    <span class="material-symbols-outlined">photo_camera</span>
                    Foto Lagi
                </a>

                <a href="{{ $home }}" class="back-link">Kembali</a>
            </div>

        </section>
    </div>
</main>

<footer class="site-footer">

    <div class="footer-grid">

        <div>
            <h3>✧ WHIMSYBOOTH</h3>
            <p>
                A little magic in every frame. Kenangan photobooth virtual
                yang terinspirasi taman peri dan cahaya bintang.
            </p>
        </div>

        <div>
            <h4>Quick Magical Trails</h4>
            <a href="{{ $home }}">Home</a>
            <a href="{{ $home }}">How It Works</a>
            <a href="{{ $home }}">Photobooth Studio</a>
            <a href="{{ $home }}">Fairy Strip Gallery</a>
        </div>

        <div>
            <h4>Enchanted Support</h4>
            <a href="{{ $home }}">FAQ / Help Sanctuary</a>
            <a href="{{ $home }}">Garden Packages</a>
            <a href="{{ $home }}">Privacy &amp; Fairy Charms</a>
            <a href="{{ $home }}">Whisper to Us</a>
        </div>

    </div>

    <div class="footer-bottom">
        <a href="{{ $home }}">
            © {{ date('Y') }} WHIMSYBOOTH. Crafted with fairy dew and starlight.
        </a>

        <a href="{{ $home }}">✿ A Little Magic in Every Frame</a>
    </div>

</footer>

{{-- Modal login --}}
<div class="modal-overlay hidden" id="modal-login">

    <div class="modal-box">

        <button type="button" class="modal-close" id="modal-login-close" aria-label="Tutup">
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="modal-head">
            <div class="modal-icon">
                <span class="material-symbols-outlined">lock_open</span>
            </div>

            <h3>Masuk ke Whimshy Sanctuary</h3>
            <p id="modal-sub">Masuk untuk mengunduh keepsake kamu</p>
        </div>

        {{-- FORM LOGIN LARAVEL --}}
        <form id="login-form" action="{{ route('login') }}" method="POST">
            @csrf

            <label>Email Sanctuary</label>

            <div class="field">
                <span class="material-symbols-outlined">mail</span>

                <input
                    type="email"
                    name="email"
                    required
                    placeholder="nama@fairymail.com"
                    id="login-email"
                >
            </div>

            <label>Kata Sandi</label>

            <div class="field">
                <span class="material-symbols-outlined">lock</span>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                >
            </div>

            <button type="submit" class="btn-primary wide">
                Masuk &amp; Download
            </button>
        </form>

        <div class="divider">
            <span>Atau lanjutkan dengan</span>
        </div>

        <div class="social-row">
            <button type="button" class="btn-ghost" data-social="Google">Google</button>
            <button type="button" class="btn-ghost" data-social="Apple">Apple ID</button>
        </div>

    </div>
</div>

<div class="modal-overlay hidden" id="modal-zoom">
    <div class="zoom-box">
        <button type="button" class="modal-close" id="modal-zoom-close" aria-label="Tutup">
            <span class="material-symbols-outlined">close</span>
        </button>

        <img id="zoom-img" alt="Pratinjau strip">
    </div>
</div>

<div class="toast hidden" id="toast">
    <span class="material-symbols-outlined" id="toast-icon">auto_awesome</span>
    <span id="toast-msg"></span>
</div>

<script>
    window.WB_TPL_BASE = "{{ asset('img/templates') }}";
</script>

<script src="{{ asset('js/wb-templates.js') }}"></script>
<script>
  window.WB_LOGGED_IN = @json(auth()->check());
  window.WB_LOGIN_URL = "{{ \Illuminate\Support\Facades\Route::has('login') ? route('login') : '' }}";
</script>
<script>
window.WB_AUTH = {
  logged_in: {{ auth()->check() ? 'true' : 'false' }},
  user: {!! auth()->check() ? json_encode(['name' => auth()->user()->name, 'email' => auth()->user()->email]) : 'null' !!},
  csrf: "{{ csrf_token() }}",
  urls: {
    login: '/login',
    register: '/register',
    logout: '/logout',
    forgot: '/forgot-password'
  }
};
</script>
<script src="{{ asset('js/wb-auth.js') }}"></script>
<script src="{{ asset('js/wb-gif.js') }}"></script>
<script src="{{ asset('js/download.js') }}"></script>

</body>
</html>