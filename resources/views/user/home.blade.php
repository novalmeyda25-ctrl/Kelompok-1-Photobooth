<!DOCTYPE html>

<html class="scroll-smooth" lang="en"><head>
<meta charset="utf-8"/>
<script>try{if(sessionStorage.getItem("wbArrive")==="1"){sessionStorage.removeItem("wbArrive");document.documentElement.classList.add("wb-arriving");setTimeout(function(){document.documentElement.classList.remove("wb-arriving")},8000);}}catch(e){}</script>
<style>html.wb-arriving::before{content:"";position:fixed;inset:0;z-index:99999;pointer-events:none;background:radial-gradient(circle at 50% 50%,#fff3fa,#ffd6ec 60%,#e8d4ff);opacity:1;transition:opacity .9s ease}html.wb-arriving.wb-veil-off::before{opacity:0}</style>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>WHIMSHYBOOTH - Interactive Real Webcam Studio &amp; Keepsake Strips</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&amp;family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="app.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#970046',
                'primary-container': '#be185d',
                'primary-light': '#fce7f3',
                'fairy-pink': '#ffe4e8',
                'rose-accent': '#e11d48',
                surface: '#fff8f7',
                'surface-dark': '#211a1b',
                subtext: '#594046'
            },
            fontFamily: {
                serif: ['"Playfair Display"', 'serif'],
                sans: ['"Plus Jakarta Sans"', 'sans-serif']
            }
        }
    }
};
</script>
<link rel="icon" type="image/png" href="{{ asset('images/whimsybooth/fairy-logo.png') }}">
<script>
  // Daftar template photobooth. Backend (admin panel) cukup kirim $templates dari controller;
  // kalau tidak ada, dipakai template bawaan di wb-templates.js. Format: lihat wb-templates.js
  window.WB_TPL_BASE = "{{ asset('img/templates') }}";
  window.WB_TEMPLATES = @json($templates ?? null);
</script>
<script src="{{ asset('js/wb-templates.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="{{ asset('css/wb-lotus.css') }}">
<style>
/* Cahaya tipis pink-putih di sekitar bunga hero (home) */
#hero-lotus{position:relative;isolation:isolate;animation:wbLotusGlow 4.8s ease-in-out infinite}
#hero-lotus::before{content:"";position:absolute;left:50%;top:50%;width:94%;aspect-ratio:1/1;transform:translate(-50%,-50%);border-radius:50%;z-index:-1;pointer-events:none;
  background:radial-gradient(circle,rgba(255,255,255,.9) 0%,rgba(255,226,242,.7) 26%,rgba(249,168,212,.32) 50%,rgba(249,168,212,0) 72%);
  filter:blur(16px);animation:wbHalo 4.8s ease-in-out infinite}
@keyframes wbLotusGlow{
  0%,100%{filter:drop-shadow(0 0 6px rgba(255,255,255,.85)) drop-shadow(0 0 16px rgba(255,160,210,.42))}
  50%{filter:drop-shadow(0 0 10px rgba(255,255,255,1)) drop-shadow(0 0 28px rgba(255,140,200,.62))}}
@keyframes wbHalo{
  0%,100%{opacity:.7;transform:translate(-50%,-50%) scale(.95)}
  50%{opacity:1;transform:translate(-50%,-50%) scale(1.07)}}
@media (prefers-reduced-motion:reduce){#hero-lotus,#hero-lotus::before{animation:none}}
/* Cahaya pink mengikuti bentuk huruf */
.wb-glow-text{text-shadow:0 0 4px rgba(255,255,255,.9),0 0 10px rgba(249,168,212,.85),0 0 20px rgba(244,114,182,.55);animation:wbTextGlow 4s ease-in-out infinite}
@keyframes wbTextGlow{
  0%,100%{text-shadow:0 0 3px rgba(255,255,255,.85),0 0 8px rgba(249,168,212,.7),0 0 16px rgba(244,114,182,.4)}
  50%{text-shadow:0 0 5px rgba(255,255,255,1),0 0 13px rgba(249,168,212,.95),0 0 26px rgba(244,114,182,.7)}}
@media (prefers-reduced-motion:reduce){.wb-glow-text{animation:none}}
/* Huruf timbul saat kursor lewat (elemen dengan atribut data-wb-pop) */
.wb-w{display:inline-block;white-space:nowrap}
.wb-ch{display:inline-block;transition:transform .35s cubic-bezier(.34,1.8,.5,1),color .3s,text-shadow .3s;will-change:transform;cursor:default}
.wb-ch.wb-hot{transform:translateY(-10px) scale(1.28) rotate(-4deg);color:#E11D48;
  text-shadow:0 0 6px rgba(255,255,255,.95),0 0 14px rgba(249,168,212,.95),0 0 28px rgba(244,114,182,.8),0 6px 10px rgba(190,24,93,.25)}
@media (prefers-reduced-motion:reduce){.wb-ch,.wb-ch.wb-hot{transition:none;transform:none}}
#hero-lotus .wb-petals{position:absolute;inset:-8% 0 0 0;width:100%;height:108%;pointer-events:none;z-index:3}
</style>
</head>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('carousel-track');

    if (!track) return;

    let isDragging = false;
    let startX = 0;
    let startScroll = 0;

    track.addEventListener('mousedown', function(e) {
        isDragging = true;
        startX = e.pageX;
        startScroll = track.scrollLeft;
        track.style.cursor = 'grabbing';
    });

    window.addEventListener('mouseup', function() {
        isDragging = false;
        track.style.cursor = 'grab';
    });

    window.addEventListener('mousemove', function(e) {
        if (!isDragging) return;

        e.preventDefault();

        track.scrollLeft = startScroll - (e.pageX - startX);
    });
});
</script>

<script>
document.addEventListener('keydown', function(e) {
    // Jangan mengganggu saat sedang mengetik
    if (
        e.target.tagName === 'INPUT' ||
        e.target.tagName === 'TEXTAREA' ||
        e.target.isContentEditable
    ) return;

    const track = document.getElementById('carousel-track');
    if (!track) return;

    if (e.key === 'ArrowRight') {
        e.preventDefault();
        document.getElementById('carousel-next')?.click();
    }

    if (e.key === 'ArrowLeft') {
        e.preventDefault();
        document.getElementById('carousel-prev')?.click();
    }
});
</script>
<body class="bg-[#FFF5F7] font-sans text-[#211a1b] antialiased selection:bg-[#FBCFE8] selection:text-[#970046]">
<!-- 1. NAVIGATION BAR (100% FULLY INTERACTIVE & FUNCTIONAL) -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-[#FCE7F3] shadow-[0_4px_25px_rgba(244,114,182,0.12)]">
<div class="h-20 max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between gap-4">
<!-- Brand Logo & Title -->
<a aria-label="Whimshybooth Home" class="flex items-center gap-3 cursor-pointer group select-none transition-transform active:scale-95" href="#hero" id="nav-brand-logo">
<img alt="Whimshybooth fairy logo" src="{{ asset('images/whimsybooth/fairy-logo.png') }}" class="h-11 w-auto object-contain group-hover:scale-110 transition-transform" style="filter:drop-shadow(0 2px 6px rgba(244,114,182,.55))"/>
<div class="flex items-center gap-2">
<span class="wb-glow-text font-serif text-[22px] sm:text-[24px] font-bold text-[#970046] tracking-tight group-hover:text-[#BE185D] transition-colors">WHIMSYBOOTH</span>
<span class="px-2.5 py-0.5 rounded-full bg-[#FFE4E8] text-[#970046] text-[11px] font-bold hidden sm:inline-flex items-center gap-1 shadow-xs border border-[#FBCFE8]">
<span class="material-symbols-outlined text-[13px] text-[#E11D48]">auto_awesome</span>Fairy Magic
          </span>
</div>
</a>
<!-- Center Nav Links -->
<nav aria-label="Main navigation" class="hidden md:flex items-center gap-1 lg:gap-2">
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-bold text-[#970046] bg-[#FFE4E8] hover:bg-[#FBCFE8] cursor-pointer transition-all active:scale-95" href="#hero">Home</a>
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#studio">Studio</a>
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#frames">Frames</a>
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#how-it-works">How It Works</a>
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#faq">FAQ</a>
<a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#contact">Contact</a>
</nav>
<!-- Right Action CTA Buttons -->
<div class="flex items-center gap-2.5 relative">
<button aria-label="Open Fairy Guide" class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#FFE4E8] text-[#970046] text-[12.5px] font-bold hover:bg-[#FBCFE8] shadow-xs active:scale-95 transition-all border border-[#FBCFE8]" id="nav-guide-btn" type="button">
<span class="material-symbols-outlined text-[16px]">menu_book</span>
<span>Guide</span>
</button>
<button aria-label="Masuk ke Akun" class="cursor-pointer inline-flex items-center justify-center px-5 py-2 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.35)] active:scale-95 transition-all" id="nav-login-btn" type="button">
          Masuk
        </button>
<button aria-label="Akun Pengguna Whimshy" class="cursor-pointer w-9 h-9 rounded-full bg-[#FFE4E8] text-[#970046] hover:bg-[#BE185D] hover:text-white transition-all flex items-center justify-center border border-[#FBCFE8] shadow-xs active:scale-95" id="nav-profile-btn" type="button">
<span class="material-symbols-outlined text-[19px]">person</span>
</button>
</div>
</div>
</header>
<!-- MAIN WRAPPER -->
<main class="w-full pt-20">
<!-- HERO SECTION (id="hero") -->
<section class="relative w-full px-4 sm:px-8 py-16 text-center overflow-hidden scroll-mt-24" id="hero">
<!-- Glow ambient background -->
<div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-[#FBCFE8]/40 to-transparent rounded-full blur-3xl pointer-events-none"></div>
<div class="relative max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-10 lg:gap-4">
<!-- TEKS HERO (bergeser ke kiri) -->
<div class="flex flex-col items-center lg:items-start lg:text-left w-full lg:w-[52%]" id="hero-text">
<!-- Fairy Pill -->
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/90 border border-[#FCE7F3] shadow-[0_2px_12px_rgba(244,114,182,0.18)] mb-6">
<span class="material-symbols-outlined text-[#BE185D] text-[18px]">auto_awesome</span>
<span class="text-[12px] font-bold text-[#970046] tracking-wider uppercase">Magical Bloom Atelier</span>
<span class="w-1.5 h-1.5 rounded-full bg-[#E11D48]"></span>
<span class="text-[11px] font-bold text-[#BE185D]">Live 4-Cut Studio</span>
</div>
<h1 data-wb-pop class="font-serif text-[42px] sm:text-[56px] text-[#970046] font-medium leading-[1.1] mb-4">
          Step Into an Enchanted <br/>
<span class="relative inline-block text-[#B4136D]">
            Fairy Garden
            <svg class="absolute -bottom-2 left-0 w-full h-3 text-[#F472B6]/60" fill="none" preserveaspectratio="none" viewbox="0 0 200 12">
<path d="M2 9C50 2 150 2 198 9" stroke="currentColor" stroke-linecap="round" stroke-width="3"></path>
</svg>
</span>
</h1>
<p class="text-[15px] sm:text-[17px] text-[#594046] max-w-2xl leading-relaxed mb-8">
          Capture dreamy photo strips, glowing fairy dust filters, and playful botanical frames in your private garden sanctuary. Pressed petals, satin sheen, and timeless keepsake memories.
        </p>
<!-- CTAs -->
<div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
<a class="cursor-pointer inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[14px] font-bold shadow-[0_8px_25px_rgba(190,24,93,0.38)] active:scale-95 transition-all" href="#studio" id="hero-studio-btn">
<span class="material-symbols-outlined text-[20px]">photo_camera</span>
            Enter Photobooth Studio
            <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
</a>
<a class="cursor-pointer inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white text-[#970046] text-[14px] font-bold border border-[#FCE7F3] shadow-sm hover:bg-[#FFF0F4] transition-all active:scale-95" href="#how-it-works">
<span class="material-symbols-outlined text-[20px] text-[#BE185D]">play_circle</span>
            Watch How It Works
          </a>
</div>
</div>
<!-- BUNGA LOTUS (mekar, di sebelah kanan teks) -->
<div class="w-full max-w-[440px] lg:max-w-none lg:w-[48%]" id="hero-lotus" data-photo="{{ asset('images/whimsybooth/lotus-open.png') }}" style="--wb-photo: url('{{ asset('images/whimsybooth/lotus-open.png') }}')">
<div class="wb-lotus" id="hero-lotus-inner">
@include('user.partials.wb-lotus')
</div>
</div>
</div>
</section>
<!-- PHOTOBOOTH STUDIO INTERACTIVE SECTION (id="studio") -->
<section class="w-full px-4 sm:px-8 md:px-12 py-10 relative scroll-mt-24" id="studio">
<div class="max-w-[1320px] mx-auto">
<!-- Section Title & Status Indicator -->
<div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-3 mb-6">
<div>
<div class="flex items-center gap-2 mb-1">
<span class="w-2 h-2 rounded-full bg-[#BE185D] animate-ping"></span>
<p class="text-[11px] text-[#BE185D] font-bold tracking-[0.18em] uppercase">YOUR CREATIVE CORNER</p>
</div>
<h2 class="font-serif text-[38px] md:text-[44px] text-[#970046] font-normal leading-tight">Photobooth studio</h2>
<p class="text-[14px] text-[#594046]">Get comfortable, find your angle, and let the fun begin.</p>
</div>
<div class="flex items-center gap-2.5">
<button class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white hover:bg-[#FFE4E8] border border-[#FBCFE8] text-[#970046] text-[11px] font-bold tracking-wide transition-all shadow-xs" id="btn-reopen-permission" title="Buka Ulang Dialog Izin Kamera" type="button">
<span class="material-symbols-outlined text-[14px] text-[#BE185D]">lock_reset</span>
<span>Izin Akses Kamera</span>
</button>
<div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#FCE7F3] border border-[#FBCFE8] text-[#970046] text-[11.5px] font-bold uppercase tracking-wider shadow-xs">
<span class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_#f59e0b]" id="studio-indicator-dot"></span>
<span id="studio-indicator-text">REQUESTING PERMISSION</span>
</div>
</div>
</div>
<!-- 2-COLUMN STUDIO LAYOUT: Left Camera (8 Cols) | Right Strip (4 Cols) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<!-- LEFT COLUMN: Camera Box + Choose Your Mood -->
<div class="lg:col-span-8 flex flex-col gap-6">
<!-- Card 1: Main Camera Card -->
<div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col relative overflow-hidden">
<!-- Camera Top Status Bar -->
<div class="flex items-center justify-between text-[#8D7075] text-[11px] font-bold tracking-[0.14em] uppercase pb-3 border-b border-[#FCE7F3]">
<div class="flex items-center gap-2 text-[#970046]">
<span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse" id="cam-lens-dot"></span>
<span id="cam-lens-title">WHIMSYBOOTH</span>
<span class="text-[10px] px-2 py-0.5 rounded-md bg-[#FFF0F4] text-[#BE185D] border border-[#FBCFE8] lowercase font-semibold" id="cam-lens-mode">FAIRY & GARDEN</span>
</div>
<div class="flex items-center gap-1.5 text-[#594046]">
<span class="material-symbols-outlined text-[14px] text-[#BE185D]">auto_awesome</span>
<span id="cam-mood-tag">ORIGINAL MOOD</span>
</div>
</div>
<!-- CAMERA VIEWFINDER FRAME (Dummy Photobooth Studio Mirror) -->
<div class="relative w-full aspect-[16/10] sm:aspect-[16/9.5] rounded-2xl overflow-hidden flex items-center justify-center transition-all duration-300 mt-4 border-2 border-[#FCE7F3] shadow-inner select-none bg-[#FFEBF0]" id="viewfinder">
<!-- DUMMY LIVE STREAM PHOTOBOOTH CONTAINER -->
<div class="relative w-full h-full overflow-hidden mirror-active transition-all duration-300 filter-original" id="dummy-camera-feed">
<img alt="Whimshy Photobooth Live View" class="w-full h-full object-cover transition-transform duration-700" id="dummy-mirror-img" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAtJWk3TJ9VqiRNV88Mwnel3QxKgk0lgFnnpaBe-k8N21h0jx0Ws6k5UuUnaXfx82D6XzbmVn0e3ofZaqOCoHGrwsl_T_Fs3wiqQf4e_MY7-TRoSWuAwXVuKNtk5T9uDdfEzkMAVWAMjKdv2dIM4kP5KKCcH5Lzg10jYNO4VYLLrp5IBPlOq8mabl2TTnmdGlA6WivTKLFjv7Ly9gYsGzisGrmJHKApxp0RAPwV6eE"/>
<!-- Aesthetic Fairy Shimmer & Vignette Overlays -->
<div class="absolute inset-0 bg-gradient-to-t from-[#970046]/35 via-transparent to-[#BE185D]/15 pointer-events-none"></div>
<div class="absolute inset-0 bg-radial-gradient pointer-events-none mix-blend-soft-light opacity-50" style="background: radial-gradient(circle, transparent 55%, rgba(190, 24, 93, 0.4) 100%);"></div>
<!-- Subtle floating flower petal elements -->
<div class="absolute top-5 right-8 text-[#FFE4E8]/80 text-[18px] pointer-events-none animate-bounce">🌸</div>
<div class="absolute bottom-8 left-8 text-[#FFE4E8]/70 text-[14px] pointer-events-none">✧</div>
<div class="absolute top-1/4 left-10 text-[#FFE4E8]/60 text-[16px] pointer-events-none">✨</div>
</div>
<!-- Viewfinder Corner Brackets -->
<div class="absolute top-3 left-3 w-6 h-6 border-t-2 border-l-2 border-[#BE185D]/70 rounded-tl pointer-events-none z-10"></div>
<div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-[#BE185D]/70 rounded-tr pointer-events-none z-10"></div>
<div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-[#BE185D]/70 rounded-bl pointer-events-none z-10"></div>
<div class="absolute bottom-3 right-3 w-6 h-6 border-b-2 border-r-2 border-[#BE185D]/70 rounded-br pointer-events-none z-10"></div>
<!-- Live Mirror Badge Indicator -->
<div class="absolute top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-white/90 backdrop-blur-sm border border-[#FBCFE8] flex items-center gap-1.5 text-[10px] text-[#970046] font-bold tracking-wider uppercase shadow-xs pointer-events-none z-10">
<span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping" id="viewfinder-mirror-dot"></span>
<span id="viewfinder-mirror-badge">Awaiting Camera Permission</span>
</div>
<!-- Watermark corner subtitle -->
<p class="absolute bottom-3 text-center w-full text-[10px] tracking-[0.2em] text-white/90 drop-shadow-[0_1px_3px_rgba(0,0,0,0.6)] uppercase pointer-events-none font-bold z-10">WHIMSYBOOTH · YOUR LITTLE GARDEN</p>
<!-- COUNTDOWN OVERLAY -->
<div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] flex items-center justify-center pointer-events-none hidden z-30" id="countdown-layer">
<span class="font-serif text-[96px] text-white font-bold drop-shadow-[0_4px_20px_rgba(151,0,70,0.8)] animate-pulse" id="countdown-number">3</span>
</div>
<!-- FLASH EFFECT -->
<div class="absolute inset-0 bg-white pointer-events-none opacity-0 z-40 transition-opacity duration-200" id="flash-effect"></div>
<!-- ============================================== -->
<!-- POPUP DIALOG DUMMY: IZIN AKSES KAMERA (STATE A) -->
<!-- ============================================== -->
<div class="absolute inset-0 bg-[#340d1f]/45 backdrop-blur-md flex items-center justify-center p-4 z-20 transition-all duration-300" id="camera-permission-modal">
<div class="max-w-[340px] sm:max-w-[380px] w-full bg-white/95 rounded-3xl border border-[#FBCFE8] shadow-[0_10px_35px_rgba(151,0,70,0.28)] p-6 sm:p-7 text-center relative flex flex-col items-center">
<!-- Soft glowing pink camera aperture icon -->
<div class="relative mb-3 flex items-center justify-center">
<div class="absolute inset-0 rounded-full bg-[#FCE7F3] blur-md scale-125"></div>
<div class="relative w-14 h-14 rounded-full bg-gradient-to-tr from-[#FFE4E8] to-[#FFF0F4] border border-[#FBCFE8] text-[#BE185D] flex items-center justify-center shadow-sm">
<span class="material-symbols-outlined text-[28px]">photo_camera</span>
</div>
<div class="absolute -top-1 -right-1 text-[13px] animate-pulse">✨</div>
</div>
<h3 class="font-serif text-[23px] font-bold text-[#970046] leading-tight">Enable Your Lens</h3>
<p class="text-[12.5px] text-[#594046] mt-2 leading-relaxed">
Whimsybooth requests access to your optical sensor to infuse your portrait with enchanted petals and timeless crystal light.
</p>
<!-- Action Buttons (Allow vs Dismiss) -->
<div class="w-full flex flex-col sm:flex-row items-center gap-2.5 mt-5">
<button class="cursor-pointer w-full flex-1 py-2.5 px-4 rounded-full bg-gradient-to-r from-[#970046] to-[#BE185D] hover:opacity-95 text-white font-bold text-[13px] shadow-[0_4px_16px_rgba(190,24,93,0.35)] flex items-center justify-center gap-1.5 transition-all active:scale-95" id="btn-allow-camera" type="button">
<span class="material-symbols-outlined text-[16px]">videocam</span>
<span>Allow Camera</span>
</button>
<button class="cursor-pointer w-full sm:w-auto py-2.5 px-5 rounded-full border border-[#FBCFE8] bg-white text-[#8D7075] hover:text-[#970046] hover:bg-[#FFF0F4] text-[12.5px] font-semibold transition-all active:scale-95" id="btn-dismiss-camera" type="button">
<span>Dismiss</span>
</button>
</div>
<!-- Privacy Note -->
<div class="mt-4 pt-3 border-t border-[#FCE7F3] flex items-center justify-center gap-1.5 text-[10.5px] text-[#8D7075] tracking-wide">
<span class="material-symbols-outlined text-[13px] text-[#BE185D]">lock</span>
<span>Moments remain encrypted on your device</span>
</div>
</div>
</div>
<!-- ============================================== -->
<!-- FALLBACK STATE DUMMY: KAMERA DITOLAK (STATE B) -->
<!-- ============================================== -->
<div class="absolute inset-0 bg-[#FFF5F7]/95 backdrop-blur-sm hidden items-center justify-center p-4 z-20 transition-all duration-300" id="camera-dismissed-fallback">
<div class="max-w-[340px] sm:max-w-[380px] w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-lg p-6 sm:p-7 text-center relative flex flex-col items-center">
<div class="w-13 h-13 w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center mb-2.5 border border-[#FBCFE8] shadow-xs">
<span class="material-symbols-outlined text-[24px]">videocam_off</span>
</div>
<h3 class="font-serif text-[21px] font-bold text-[#970046]">Camera Lens In Repose</h3>
<p class="text-[12px] text-[#594046] mt-1.5 leading-relaxed">
We could not summon your video stream. Your device shutter may be obscured or claimed by another application.
</p>
<div class="w-full bg-[#FFF8F9] border border-[#FCE7F3] rounded-2xl p-3 my-3 text-left">
<p class="text-[10px] uppercase font-bold text-[#BE185D] tracking-wider mb-1">TROUBLESHOOTING STEPS:</p>
<ul class="text-[11px] text-[#594046] space-y-1 list-disc list-inside">
<li>Verify permissions in your browser URL lock icon.</li>
<li>Ensure no other video app (Zoom, Meet) holds the camera.</li>
</ul>
</div>
<div class="w-full flex items-center gap-2">
<button class="cursor-pointer flex-1 py-2.5 px-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[12.5px] font-bold shadow-xs transition-all active:scale-95 flex items-center justify-center gap-1" id="btn-try-again-camera" type="button">
<span class="material-symbols-outlined text-[15px]">refresh</span>
<span>Try Again</span>
</button>
<button class="cursor-pointer py-2.5 px-3.5 rounded-full border border-[#FBCFE8] bg-white text-[#970046] hover:bg-[#FFF0F4] text-[12px] font-semibold transition-all active:scale-95" onclick="alert('🌸 Fitur upload dummy: Silakan coba foto langsung dengan mengizinkan kamera!');" type="button">
<span>Upload Photo</span>
</button>
</div>
</div>
</div>
</div>
<!-- CONTROLS ROW -->
<div class="flex flex-wrap items-center justify-between gap-3 pt-5 mt-2 border-t border-[#FCE7F3]">
<!-- Mirror Toggle -->
<button class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FCE7F3] transition-colors shadow-xs active:scale-95" id="btn-toggle-mirror" title="Toggle Cermin Horizontal (Mirror)" type="button">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">sync_alt</span>
<span id="lbl-mirror">Mirror: On</span>
</button>
<!-- Timer Segmented Buttons -->
<div class="flex items-center gap-2.5">
<span class="text-[12.5px] font-medium text-[#594046]">Timer</span>
<div class="inline-flex items-center bg-[#FFF0F4] rounded-full p-1 gap-1 border border-[#FBCFE8]">
<button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-bold bg-[#BE185D] text-white shadow-xs cursor-pointer" data-sec="3" type="button">3s</button>
<button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-medium text-[#8D7075] hover:text-[#970046] cursor-pointer" data-sec="5" type="button">5s</button>
<button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-medium text-[#8D7075] hover:text-[#970046] cursor-pointer" data-sec="10" type="button">10s</button>
</div>
</div>
<!-- Flash Toggle -->
<button class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FCE7F3] transition-colors shadow-xs active:scale-95" id="btn-toggle-flash" type="button">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">auto_awesome</span>
<span id="lbl-flash">Flash <span class="text-[#8D7075] font-normal">Off</span></span>
</button>
</div>
<!-- SHUTTER BUTTON TRIGGER AREA -->
<div class="flex flex-col items-center justify-center pt-5 pb-2">
<div class="w-[76px] h-[76px] rounded-full border-2 border-[#F472B6] p-1.5 flex items-center justify-center shadow-[0_0_20px_rgba(244,114,182,0.35)] hover:border-[#BE185D] transition-colors">
<button aria-label="Capture photo" class="cursor-pointer w-full h-full rounded-full bg-gradient-to-tr from-[#970046] via-[#BE185D] to-[#E11D48] hover:opacity-95 active:scale-95 transition-all shadow-[0_4px_16px_rgba(190,24,93,0.4)] flex items-center justify-center ring-2 ring-white" id="btn-capture-shutter" type="button">
<span class="material-symbols-outlined text-white text-[30px]">photo_camera</span>
</button>
</div>
<p class="text-[12.5px] text-[#594046] mt-2.5 font-medium flex items-center gap-1" id="shutter-caption">
<span class="material-symbols-outlined text-[14px] text-[#BE185D]">touch_app</span>
                  Click to capture aesthetic photobooth moment
                </p>
</div>
</div>
<!-- Card 2: Choose your mood (Photo Filters) -->
<div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col">
<div class="flex items-center justify-between pb-3.5 border-b border-[#FCE7F3]">
<h3 class="font-serif text-[22px] font-medium text-[#970046] tracking-tight">Choose your mood</h3>
<span class="text-[11px] font-bold text-[#BE185D] tracking-[0.14em] uppercase">STUDIO PHOTO FILTERS</span>
</div>
<!-- 4 Swatches matching live filter classes -->
<div class="flex flex-nowrap gap-3 pt-4 pb-3 overflow-x-auto filter-scroll w-full min-w-0">
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border-2 border-[#BE185D] bg-[#FFE4E8]/60 transition-all text-center cursor-pointer" data-filter="original" data-filter-css="none" data-title="Original" type="button">
<div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FBCFE8]" style="background: linear-gradient(135deg, #FFF0F4 0%, #FCE7F3 50%, #FFE4E8 100%);"></div>
<span class="text-[12.5px] font-bold text-[#970046]">Original</span>
</button>
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer" data-filter="soft-glow" data-filter-css="contrast(102%) brightness(108%) saturate(118%) sepia(8%) hue-rotate(-8deg)" data-title="Soft glow" type="button">
<div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]" style="background: linear-gradient(135deg, #FFE4E8 0%, #FBCFE8 50%, #FDA4AF 100%);"></div>
<span class="text-[12.5px] font-medium text-[#594046]">Soft glow</span>
</button>
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer" data-filter="golden-hour" data-filter-css="contrast(106%) brightness(105%) saturate(130%) sepia(28%)" data-title="Golden hour" type="button">
<div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 50%, #FED7AA 100%);"></div>
<span class="text-[12.5px] font-medium text-[#594046]">Golden hour</span>
</button>
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer" data-filter="dreamy" data-filter-css="contrast(98%) brightness(112%) saturate(125%) hue-rotate(295deg)" data-title="Dreamy" type="button">
<div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]" style="background: linear-gradient(135deg, #F3E8FF 0%, #E9D5FF 50%, #FCE7F3 100%);"></div>
<span class="text-[12.5px] font-medium text-[#594046]">Dreamy</span>
</button>
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white text-center cursor-pointer"
data-filter="rose"
data-filter-css="contrast(105%) brightness(106%) saturate(125%) sepia(12%)"
data-title="Rose"
type="button">
    <div class="w-full h-14 rounded-xl mb-2"
    style="background: linear-gradient(135deg, #FDA4AF, #FBCFE8, #BE185D);"></div>
    <span>Rose</span>
</button>
<!-- Lavender -->
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
data-filter="lavender"
data-filter-css="contrast(100%) brightness(108%) saturate(110%) hue-rotate(260deg)"
data-title="Lavender" type="button">
    <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
    style="background: linear-gradient(135deg, #E9D5FF, #C4B5FD, #A78BFA);"></div>
    <span class="text-[12.5px] font-medium text-[#594046]">Lavender</span>
</button>

<!-- Vintage -->
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
data-filter="vintage"
data-filter-css="sepia(25%) contrast(95%) brightness(105%) saturate(85%)"
data-title="Vintage" type="button">
    <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
    style="background: linear-gradient(135deg, #E7C9A9, #C49A78, #8D6E63);"></div>
    <span class="text-[12.5px] font-medium text-[#594046]">Vintage</span>
</button>

<!-- Fresh Garden -->
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
data-filter="fresh-garden"
data-filter-css="contrast(105%) brightness(105%) saturate(125%) hue-rotate(15deg)"
data-title="Fresh Garden" type="button">
    <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
    style="background: linear-gradient(135deg, #D9F99D, #86EFAC, #A7F3D0);"></div>
    <span class="text-[12.5px] font-medium text-[#594046]">Fresh Garden</span>
</button>

<!-- Fairy Dust -->
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
data-filter="fairy-dust"
data-filter-css="brightness(110%) contrast(95%) saturate(115%) sepia(10%) hue-rotate(285deg)"
data-title="Fairy Dust" type="button">
    <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
    style="background: linear-gradient(135deg, #FCE7F3, #DDD6FE, #F9A8D4);"></div>
    <span class="text-[12.5px] font-medium text-[#594046]">Fairy Dust</span>
</button>

<!-- Peach Bloom -->
<button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
data-filter="peach-bloom"
data-filter-css="brightness(106%) saturate(115%) sepia(15%) hue-rotate(340deg)"
data-title="Peach Bloom" type="button">
    <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
    style="background: linear-gradient(135deg, #FED7AA, #FDBA9A, #FBCFE8);"></div>
    <span class="text-[12.5px] font-medium text-[#594046]">Peach Bloom</span>
</button>
</div>
</div>

<!-- FAIRY ENCHANT BANNER -->
<div class="fairy-enchant-banner">
    <img
        src="{{ asset('images/whimsybooth/fairy-enchant.png') }}"
        alt="Fairies enchant this area"
    >
</div>

</div>
<!-- RIGHT COLUMN: Photo Strip Preview (lg:col-span-4) -->
<div class="lg:col-span-4 flex flex-col">
<div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col">
<div class="w-full flex items-center justify-between mb-4">
<div>
<p class="text-[10.5px] text-[#BE185D] font-bold tracking-[0.16em] uppercase">YOUR LITTLE COLLECTION</p>
<h3 class="font-serif text-[26px] font-medium text-[#970046] tracking-tight">Photo strip</h3>
</div>
<div class="px-3 py-1 rounded-full bg-[#FFE4E8] text-[#970046] text-[12px] font-bold border border-[#FBCFE8]">
<span id="snapped-count">0</span> / <span id="snapped-total">4</span>
                </div>
</div>
<!-- PHOTO STRIP: isi (jumlah slot & layout) dibangun app.js mengikuti template yang dipilih -->
<div class="w-full rounded-2xl border-2 border-[#FBCFE8] shadow-inner overflow-hidden transition-all duration-300" id="main-strip-canvas"></div>
<!-- ACTION BUTTONS -->
<div class="w-full mt-4 flex items-center gap-2.5">
<button class="cursor-pointer flex-1 py-3 px-3 rounded-full border border-[#FBCFE8] bg-white text-[#970046] text-[12.5px] font-bold hover:bg-[#FFF0F4] flex items-center justify-center gap-1.5 transition-colors shadow-xs active:scale-95" id="btn-retake-all" type="button">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">restart_alt</span>
<span>Retake all</span>
</button>
<button class="cursor-pointer flex-1 py-3 px-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[12.5px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.32)] flex items-center justify-center gap-1.5 transition-all active:scale-95" id="btn-save-strip" type="button">
<span>Save photo strip</span>
<span class="material-symbols-outlined text-[16px]">arrow_downward</span>
</button>
</div>
<p class="text-[11.5px] text-center text-[#8D7075] mt-3 leading-relaxed">
                Hasil snapshot cermin studio Anda langsung muncul di tiap frame slot. Klik salah satu slot kapan pun untuk retake pose tersebut.
              </p>
</div>
</div>
</div>
</div>
</section>
<!-- 3. TEMPLATE CAROUSEL SECTION (id="frames") -->
<section class="w-full px-4 sm:px-8 md:px-12 py-12 relative bg-[#FFF0F4]/60 scroll-mt-24" id="frames">
<div class="max-w-[1320px] mx-auto flex flex-col">
<div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-2 mb-6">
<div>
<p class="text-[11px] text-[#BE185D] font-bold tracking-[0.18em] uppercase mb-1">MADE FOR YOUR MOMENTS</p>
<h2 class="font-serif text-[36px] sm:text-[44px] text-[#970046] font-normal leading-tight">Find your little frame</h2>
<p class="text-[14.5px] text-[#594046]">Choose a style that feels like you.</p>
</div>
<div class="px-3.5 py-1 rounded-full bg-white border border-[#FBCFE8] text-[11px] font-bold text-[#BE185D] tracking-widest uppercase shadow-xs">
            COLLECTIONS
          </div>
</div>
<!-- CAROUSEL TRACK WITH LEFT / RIGHT ARROWS -->
<div class="relative w-full px-2 sm:px-4">
<!-- Left Arrow -->
<button aria-label="Previous frame" class="cursor-pointer absolute -left-2 sm:-left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 rounded-full bg-white shadow-[0_6px_20px_rgba(244,114,182,0.3)] border-2 border-[#FBCFE8] flex items-center justify-center text-[#970046] hover:bg-[#BE185D] hover:text-white hover:scale-105 active:scale-95 transition-all" id="carousel-prev" type="button">
<span class="material-symbols-outlined text-[24px]">arrow_back_ios_new</span>
</button>
<!-- Right Arrow -->
<button aria-label="Next frame" class="cursor-pointer absolute -right-2 sm:-right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 rounded-full bg-white shadow-[0_6px_20px_rgba(244,114,182,0.3)] border-2 border-[#FBCFE8] flex items-center justify-center text-[#970046] hover:bg-[#BE185D] hover:text-white hover:scale-105 active:scale-95 transition-all" id="carousel-next" type="button">
<span class="material-symbols-outlined text-[24px]">arrow_forward_ios</span>
</button>
<!-- Frames Flex Container -->
<div class="w-full overflow-x-auto scrollbar-none py-6 px-3 flex items-stretch gap-6 transition-all scroll-smooth" id="carousel-track">
<!-- Card 1: Garden Daydream (Selected by default) -->
<div class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border-2 border-[#BE185D] bg-[#FFE4E8]/50 shadow-[0_8px_24px_rgba(244,114,182,0.22)] cursor-pointer transition-all duration-300 transform scale-[1.03] flex flex-col justify-between" data-bg="#FFF0F4" data-template-id="garden" data-frame-name="Garden" data-slot="#FFE4E8">
<div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner" style="background: radial-gradient(circle at 35% 30%, #FFE4E8 0%, #FBCFE8 50%, #FDA4AF 100%);">
<div class="w-10 h-10 rounded-full bg-white/80 text-[#970046] mb-3 flex items-center justify-center shadow-xs">
<svg class="w-6 h-6 fill-current" viewbox="0 0 24 24"><circle cx="12" cy="12" r="3.5"></circle><circle cx="12" cy="5.5" r="3.2"></circle><circle cx="12" cy="18.5" r="3.2"></circle><circle cx="5.5" cy="12" r="3.2"></circle><circle cx="18.5" cy="12" r="2.8"></circle></svg>
</div>
<h4 class="font-serif text-[26px] text-[#970046] lowercase leading-snug font-medium">garden<br/>daydream</h4>
<p class="text-[10.5px] tracking-[0.2em] text-[#970046] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">A LITTLE BLOOM</p>
</div>
<div class="mt-4 px-1 text-left">
<div class="flex items-center justify-between">
<p class="text-[17px] font-bold text-[#211a1b]">Garden Daydream</p>
<span class="material-symbols-outlined text-[#BE185D] text-[18px]">check_circle</span>
</div>
<p class="text-[13px] text-[#594046] mt-0.5">Soft greens and little flowers</p>
</div>
</div>
<!-- Card 2: Fairy Whispers -->
<div class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between" data-bg="#FAF5FF" data-template-id="fairy-whispers" data-frame-name="Fairy Whispers" data-slot="#F3E8FF">
<div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner" style="background: radial-gradient(circle at 75% 30%, #F5F3FF 0%, #E9D5FF 55%, #FBCFE8 100%);">
<div class="flex items-center gap-1 text-[#8C2049] mb-3 bg-white/70 px-2.5 py-1 rounded-full shadow-xs">
<span class="text-[12px]">✧</span><span class="text-[9px]">•</span><span class="text-[16px]">✦</span><span class="text-[9px]">•</span><span class="text-[12px]">✧</span>
</div>
<h4 class="font-serif text-[26px] text-[#4A1D42] lowercase leading-snug font-medium">fairy<br/>whispers</h4>
<p class="text-[10.5px] tracking-[0.2em] text-[#8C2049] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">MADE OF MAGIC</p>
</div>
<div class="mt-4 px-1 text-left">
<p class="text-[17px] font-bold text-[#211a1b]">Fairy Whispers</p>
<p class="text-[13px] text-[#594046] mt-0.5">A dreamy touch of fairy dust</p>
</div>
</div>
<!-- Card 3: Sweet Memories -->
<div class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between" data-bg="#FFFBEB" data-template-id="sweet-memories" data-frame-name="Sweet Memories" data-slot="#FEF3C7">
<div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner" style="background: radial-gradient(circle at 50% 35%, #FEF3C7 0%, #FDE68A 50%, #FBCFE8 100%);">
<div class="w-10 h-10 rounded-full bg-white/80 text-[#970046] mb-3 flex items-center justify-center shadow-xs">
<svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.8" viewbox="0 0 24 24"><circle cx="12" cy="12" r="2.8"></circle><circle cx="12" cy="5.5" r="2.8"></circle><circle cx="12" cy="18.5" r="2.8"></circle><circle cx="5.5" cy="12" r="2.8"></circle><circle cx="18.5" cy="12" r="2.8"></circle></svg>
</div>
<h4 class="font-serif text-[26px] text-[#78350F] lowercase leading-snug font-medium">sweet<br/>memories</h4>
<p class="text-[10.5px] tracking-[0.2em] text-[#970046] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">THE GOOD OLD DAYS</p>
</div>
<div class="mt-4 px-1 text-left">
<p class="text-[17px] font-bold text-[#211a1b]">Sweet Memories</p>
<p class="text-[13px] text-[#594046] mt-0.5">A warm vintage-inspired look</p>
</div>
</div>
<!-- Card 4: Blush Petals -->
<div class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between" data-bg="#FFF0F5" data-template-id="blush-petals" data-frame-name="Blush Petals" data-slot="#FCE7F3">
<div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner" style="background: radial-gradient(circle at 75% 30%, #FFE4E8 0%, #F472B6/50 60%, #BE185D/30 100%);">
<div class="w-10 h-10 rounded-full bg-white/80 text-[#BE185D] mb-3 flex items-center justify-center shadow-xs">
<span class="material-symbols-outlined text-[24px]">favorite</span>
</div>
<h4 class="font-serif text-[26px] text-[#970046] lowercase leading-snug font-medium">blush<br/>petals</h4>
<p class="text-[10.5px] tracking-[0.2em] text-[#BE185D] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">LOVELY LITTLE THINGS</p>
</div>
<div class="mt-4 px-1 text-left">
<p class="text-[17px] font-bold text-[#211a1b]">Blush Petals</p>
<p class="text-[13px] text-[#594046] mt-0.5">A soft pink daydream</p>
</div>
</div>
</div>
</div>
<div class="mt-4 flex items-center justify-center text-center">
<div class="px-5 py-2 rounded-full bg-white border border-[#FBCFE8] shadow-xs flex items-center gap-2">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">palette</span>
<p class="text-[13.5px] text-[#594046]">
              Selected frame: <strong class="text-[#970046] font-bold" id="lbl-selected-frame">Garden</strong>
</p>
</div>
</div>
</div>
</section>
<!-- 4. HOW IT WORKS SECTION (id="how-it-works") -->
<section class="w-full px-4 sm:px-8 md:px-12 py-16 bg-[#FFF5F7] scroll-mt-24" id="how-it-works">
<div class="max-w-5xl mx-auto text-center flex flex-col items-center">
<div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#FFE4E8] text-[#970046] text-[12px] font-bold mb-3 shadow-xs">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">spa</span>
<span>Four Steps of Petal Magic</span>
</div>
<h2 data-wb-pop class="wb-glow-text font-serif text-[36px] sm:text-[44px] text-[#970046] font-medium mb-3">How The Whimsy Magic Unfolds</h2>
<p class="text-[15px] text-[#594046] max-w-xl mb-12">
          Everything happens directly inside your web sanctuary. Zero complicated apps, no watermarks, just high-resolution fairy keepsakes.
        </p>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 w-full text-left">
<div class="p-6 rounded-3xl bg-white border border-[#FCE7F3] shadow-sm flex flex-col justify-between">
<span class="font-serif text-[42px] text-[#FBCFE8] font-bold leading-none mb-3">01</span>
<div>
<h3 class="text-[17px] font-bold text-[#211a1b] mb-1">Pick Your Frame</h3>
<p class="text-[13px] text-[#594046]">Select from fairy 4-cuts, romantic duos, or whimsical cinema strips with rose floral borders.</p>
</div>
<div class="mt-4 pt-3 border-t border-[#FCE7F3] text-[11px] font-bold text-[#BE185D] uppercase tracking-wider">Step One Completed</div>
</div>
<div class="p-6 rounded-3xl bg-white border border-[#FCE7F3] shadow-sm flex flex-col justify-between">
<span class="font-serif text-[42px] text-[#FBCFE8] font-bold leading-none mb-3">02</span>
<div>
<h3 class="text-[17px] font-bold text-[#211a1b] mb-1">Live Studio Mirror</h3>
<p class="text-[13px] text-[#594046]">Enjoy your instant live photobooth mirror right on your phone or laptop without any setup hassles.</p>
</div>
<div class="mt-4 pt-3 border-t border-[#FCE7F3] text-[11px] font-bold text-[#BE185D] uppercase tracking-wider">Instant &amp; Private In-Browser</div>
</div>
<div class="p-6 rounded-3xl bg-white border border-[#FCE7F3] shadow-sm flex flex-col justify-between">
<span class="font-serif text-[42px] text-[#FBCFE8] font-bold leading-none mb-3">03</span>
<div>
<h3 class="text-[17px] font-bold text-[#211a1b] mb-1">Pose with Filters</h3>
<p class="text-[13px] text-[#594046]">Switch glowing rose filters, adjust 3s to 10s timers, and retake individual slots whenever you like.</p>
</div>
<div class="mt-4 pt-3 border-t border-[#FCE7F3] text-[11px] font-bold text-[#BE185D] uppercase tracking-wider">Retake Any Slot Easily</div>
</div>
<div class="p-6 rounded-3xl bg-white border border-[#FCE7F3] shadow-sm flex flex-col justify-between">
<span class="font-serif text-[42px] text-[#FBCFE8] font-bold leading-none mb-3">04</span>
<div>
<h3 class="text-[17px] font-bold text-[#211a1b] mb-1">Save &amp; Share</h3>
<p class="text-[13px] text-[#594046]">Download high-definition PNG strips, print-ready sheets, or animated GIF bursts for your social stories.</p>
</div>
<div class="mt-4 pt-3 border-t border-[#FCE7F3] text-[11px] font-bold text-[#BE185D] uppercase tracking-wider">Ready for Print &amp; Social</div>
</div>
</div>
</div>
</section>
<!-- 5. FAQ SECTION (id="faq") -->
<section class="w-full px-4 sm:px-8 md:px-12 py-16 bg-[#FFF0F4]/50 scroll-mt-24" id="faq">
<div class="max-w-3xl mx-auto flex flex-col items-center">
<div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFE4E8] text-[#970046] text-[12px] font-bold mb-3 shadow-xs">
<span class="material-symbols-outlined text-[16px] text-[#BE185D]">help</span>
<span>Garden Whispers &amp; Inquiries</span>
</div>
<h2 class="font-serif text-[36px] text-[#970046] text-center mb-8 font-medium">Frequently Asked Questions</h2>
<div class="w-full flex flex-col gap-3">
<div class="faq-item p-4 sm:p-5 rounded-2xl bg-white border border-[#FCE7F3] shadow-xs cursor-pointer transition-all hover:border-[#BE185D]">
<div class="flex items-center justify-between">
<h3 class="text-[15.5px] font-bold text-[#211a1b]">Can I retake just one photo without restarting the strip?</h3>
<span class="material-symbols-outlined text-[#BE185D] transition-transform duration-200">expand_more</span>
</div>
<div class="faq-answer hidden mt-2.5 pt-2.5 border-t border-[#FCE7F3] text-[#594046] text-[13.5px] leading-relaxed">
              Yes, absolutely! Simply click on any individual photo slot (Slot 1, 2, 3, or 4) on the keepsake strip preview, click shutter, and snap again. Your other three frames stay perfectly preserved.
            </div>
</div>
<div class="faq-item p-4 sm:p-5 rounded-2xl bg-white border border-[#FCE7F3] shadow-xs cursor-pointer transition-all hover:border-[#BE185D]">
<div class="flex items-center justify-between">
<h3 class="text-[15.5px] font-bold text-[#211a1b]">Do my photobooth photos get uploaded to public servers?</h3>
<span class="material-symbols-outlined text-[#BE185D] transition-transform duration-200">expand_more</span>
</div>
<div class="faq-answer hidden mt-2.5 pt-2.5 border-t border-[#FCE7F3] text-[#594046] text-[13.5px] leading-relaxed">
              Your photobooth studio runs 100% locally in your browser. Snaps are generated straight on your device memory into an in-memory canvas. Moments remain private and encrypted on your device.
            </div>
</div>
<div class="faq-item p-4 sm:p-5 rounded-2xl bg-white border border-[#FCE7F3] shadow-xs cursor-pointer transition-all hover:border-[#BE185D]">
<div class="flex items-center justify-between">
<h3 class="text-[15.5px] font-bold text-[#211a1b]">Which file formats can I download?</h3>
<span class="material-symbols-outlined text-[#BE185D] transition-transform duration-200">expand_more</span>
</div>
<div class="faq-answer hidden mt-2.5 pt-2.5 border-t border-[#FCE7F3] text-[#594046] text-[13.5px] leading-relaxed">
              You can export crystal-clear PNG strips for printing on 2x6 photo paper, standard high-res JPGs, and looping Burst GIFs with animated fairy dust particles.
            </div>
</div>
<div class="faq-item p-4 sm:p-5 rounded-2xl bg-white border border-[#FCE7F3] shadow-xs cursor-pointer transition-all hover:border-[#BE185D]">
<div class="flex items-center justify-between">
<h3 class="text-[15.5px] font-bold text-[#211a1b]">How do I use WHIMSYBOOTH for events or birthdays?</h3>
<span class="material-symbols-outlined text-[#BE185D] transition-transform duration-200">expand_more</span>
</div>
<div class="faq-answer hidden mt-2.5 pt-2.5 border-t border-[#FCE7F3] text-[#594046] text-[13.5px] leading-relaxed">
              We offer full Kiosk Mode for iPad and touchscreen setups with custom branded floral frames and guest QR code scans. Reach out through our Atelier Concierge below!
            </div>
</div>
</div>
</div>
</section>
<!-- 6. CONTACT SECTION (id="contact") -->
<section class="w-full px-4 sm:px-8 md:px-12 py-16 scroll-mt-24" id="contact">
<div class="max-w-4xl mx-auto rounded-3xl bg-gradient-to-tr from-[#FFE4E8] via-[#FCE7F3] to-[#FFF0F4] border border-[#FBCFE8] p-8 md:p-12 text-center shadow-[0_8px_30px_rgba(244,114,182,0.2)] flex flex-col items-center">
<div class="w-12 h-12 rounded-full bg-[#BE185D] flex items-center justify-center text-white mb-3 shadow-md">
<span class="material-symbols-outlined text-[24px]">local_florist</span>
</div>
<h2 class="wb-glow-text font-serif text-[32px] text-[#970046] font-medium">Need a Custom Fairy Theme?</h2>
<p class="text-[14.5px] text-[#594046] max-w-md mt-2 mb-6">
          Planning a wedding, fairy core birthday, or brand pop-up? Let us craft tailored digital botanical borders and custom sticker sets.
        </p>
<div class="flex flex-wrap items-center justify-center gap-3">
<button class="cursor-pointer px-7 py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13.5px] font-bold shadow-md transition-all active:scale-95" id="btn-concierge" type="button">
            Contact Atelier Concierge
          </button>
<a class="px-6 py-3 rounded-full bg-white text-[#970046] text-[13.5px] font-bold border border-[#FBCFE8] hover:bg-[#FFF0F4] transition-all active:scale-95" href="https://instagram.com" rel="noopener noreferrer" target="_blank">
            Instagram @whimsybooth
          </a>
</div>
</div>
</section>
</main>
<!-- 7. FOOTER -->
<footer class="w-full bg-[#FFF0F4] text-[#594046] border-t border-[#FCE7F3] pt-12 pb-8">
<div class="max-w-7xl mx-auto px-4 sm:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 pb-10 border-b border-[#FBCFE8]">
<div class="lg:col-span-4 flex flex-col gap-3">
<div class="flex items-center gap-2">
<img alt="Whimsybooth fairy logo" src="{{ asset('images/whimsybooth/fairy-logo.png') }}" class="h-9 w-auto object-contain" style="filter:drop-shadow(0 2px 5px rgba(244,114,182,.5))"/>
<span class="wb-glow-text font-serif text-[22px] font-bold text-[#970046]">WHIMSYBOOTH</span>
</div>
<p class="text-[13px] leading-relaxed text-[#594046] max-w-sm">
            A Little Magic in Every Frame. Enchanted virtual photobooth memories inspired by enchanted flora, soft pink petals, and timeless celebration.
          </p>
</div>
<div class="lg:col-span-2 flex flex-col gap-2">
<h4 class="text-[13px] font-bold text-[#970046]">Quick Magical Trails</h4>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#hero">Home</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#how-it-works">How It Works</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#studio">Photobooth Studio</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#frames">Fairy Strip Gallery</a>
</div>
<div class="lg:col-span-3 flex flex-col gap-2">
<h4 class="text-[13px] font-bold text-[#970046]">Enchanted Support</h4>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#faq">FAQ / Help Sanctuary</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#frames">Garden Packages</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#hero">Privacy &amp; Fairy Charms</a>
<a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#contact">Whisper to Us</a>
</div>
<div class="lg:col-span-3 flex flex-col gap-2">
<h4 class="text-[13px] font-bold text-[#970046]">Garden Newsletter</h4>
<p class="text-[13px] text-[#594046]">Receive new seasonal botanical frames, fairy dust overlays, and celebration inspirations.</p>
<form class="mt-1 flex items-center bg-white rounded-full p-1 pl-3 shadow-xs border border-[#FBCFE8]" onsubmit="event.preventDefault(); alert('🌸 Terima kasih! Email Anda telah terdaftar.');">
<input class="flex-1 bg-transparent text-[13px] text-[#211a1b] placeholder:text-[#8D7075] focus:outline-none" placeholder="Your enchanted email..." required="" type="email"/>
<button aria-label="Subscribe Newsletter" class="w-8 h-8 rounded-full bg-[#BE185D] text-white flex items-center justify-center hover:bg-[#970046] transition-colors shadow-xs" type="submit">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</button>
</form>
</div>
</div>
<div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-[#8D7075] text-[12px]">
<div>© 2024 WHIMSYBOOTH. Crafted with fairy dew and pink starlight. All rights reserved.</div>
<div class="flex items-center gap-1.5 text-[#970046] font-medium">
<span>✿</span>
<span>A Little Magic in Every Frame</span>
</div>
</div>
</div>
</footer>
<!-- POPUP MODAL: FAIRY PHOTOBOOTH QUICK GUIDE -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-guide">
<div class="max-w-md w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 sm:p-7 relative animate-in fade-in duration-200">
<button aria-label="Close Guide" class="cursor-pointer absolute top-4 right-4 w-9 h-9 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center transition-all" id="modal-guide-close" type="button">
<span class="material-symbols-outlined text-[20px]">close</span>
</button>
<div class="flex items-center gap-3 mb-4">
<div class="w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center shadow-xs">
<span class="material-symbols-outlined text-[24px]">menu_book</span>
</div>
<div>
<h3 class="font-serif text-[22px] font-bold text-[#970046] leading-snug">Fairy Quick Guide</h3>
<p class="text-[12px] text-[#8D7075]">4 Langkah Praktis Bersenang-senang di Booth</p>
</div>
</div>
<div class="space-y-2.5 my-4 text-left">
<div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">
<span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">1</span>
<div>
<p class="text-[13px] font-bold text-[#211a1b]">Studio Mirror Ready</p>
<p class="text-[12px] text-[#594046]">Cermin live studio langsung aktif dan siap berpose tanpa install aplikasi apa pun.</p>
</div>
</div>
<div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">
<span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">2</span>
<div>
<p class="text-[13px] font-bold text-[#211a1b]">Choose Frame &amp; Filter Mood</p>
<p class="text-[12px] text-[#594046]">Pilih tema botanical (Garden, Whispers) dan mood glow langsung pada cermin studio.</p>
</div>
</div>
<div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">
<span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">3</span>
<div>
<p class="text-[13px] font-bold text-[#211a1b]">Pose with Timer (3s / 5s / 10s)</p>
<p class="text-[12px] text-[#594046]">Tekan Shutter untuk mengambil 4 pose berurutan dengan flash fairy yang estetik.</p>
</div>
</div>
<div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">
<span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">4</span>
<div>
<p class="text-[13px] font-bold text-[#211a1b]">Download &amp; Print Keepsake</p>
<p class="text-[12px] text-[#594046]">Klik 'Save photo strip' untuk mengunduh format cetak PNG resolusi tinggi!</p>
</div>
</div>
</div>
<div class="flex items-center gap-2 pt-2">
<button class="cursor-pointer flex-1 py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white font-bold text-[13px] shadow-sm active:scale-95 transition-all" id="modal-guide-start" type="button">
          Ayo Mulai Foto!
        </button>
<button class="cursor-pointer px-5 py-3 rounded-full border border-[#FBCFE8] bg-white text-[#8D7075] hover:text-[#970046] hover:bg-[#FFF0F4] font-semibold text-[13px] transition-all" id="modal-guide-dismiss" type="button">
          Tutup Panduan
        </button>
</div>
</div>
</div>
<!-- POPUP MODAL: MASUK KE WHIMSHY SANCTUARY -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-login">
<div class="max-w-md w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 sm:p-7 relative animate-in fade-in duration-200">
<button aria-label="Close Login Modal" class="cursor-pointer absolute top-4 right-4 w-9 h-9 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center transition-all" id="modal-login-close" type="button">
<span class="material-symbols-outlined text-[20px]">close</span>
</button>
<div class="text-center mb-5">
<div class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#FFE4E8] to-[#FCE7F3] text-[#BE185D] flex items-center justify-center mx-auto mb-2 border border-[#FBCFE8] shadow-xs">
<span class="material-symbols-outlined text-[26px]">lock_open</span>
</div>
<h3 class="font-serif text-[24px] font-bold text-[#970046]">Masuk ke Whimsy Sanctuary</h3>
<p class="text-[12.5px] text-[#8D7075] mt-1">Akses album strip tersimpan dan unduh tanpa batas resolusi tinggi</p>
</div>
<form class="space-y-3.5" id="login-form"
      action="{{ route('login') }}" method="POST">
    @csrf
<div>
<label class="block text-[11px] font-bold text-[#594046] uppercase mb-1.5 tracking-wider">Email Sanctuary</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#BE185D] text-[18px]">mail</span>
<input class="w-full pl-10 pr-4 py-2.5 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[13px] text-[#211a1b] focus:outline-none focus:border-[#BE185D] focus:ring-1 focus:ring-[#BE185D] transition-colors" placeholder="nama@fairymail.com" required="" type="email" name="email"/>
</div>
</div>
<div>
<div class="flex items-center justify-between mb-1.5">
<label class="text-[11px] font-bold text-[#594046] uppercase tracking-wider">Kata Sandi</label>
<a class="text-[11px] text-[#BE185D] hover:underline font-semibold" href="#" onclick="alert('🌸 Tautan reset sandi telah dikirim ke email!'); return false;">Lupa Sandi?</a>
</div>
<div class="relative">
<span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#BE185D] text-[18px]">lock</span>
<input class="w-full pl-10 pr-4 py-2.5 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[13px] text-[#211a1b] focus:outline-none focus:border-[#BE185D] focus:ring-1 focus:ring-[#BE185D] transition-colors" placeholder="••••••••" required="" type="password" name="password"/>
</div>
</div>
<button class="cursor-pointer w-full py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white font-bold text-[13.5px] shadow-[0_4px_16px_rgba(190,24,93,0.32)] active:scale-95 transition-all" type="submit">
          Masuk Sekarang
        </button>
</form>
<div class="relative my-4 text-center">
<div class="absolute inset-0 flex items-center"><div class="w-full border-t border-[#FCE7F3]"></div></div>
<span class="relative bg-white px-3 text-[11px] uppercase tracking-wider text-[#8D7075] font-semibold">Atau lanjutkan dengan</span>
</div>
<div class="grid grid-cols-2 gap-2.5">
<button class="cursor-pointer py-2.5 px-3 rounded-full border border-[#FBCFE8] hover:bg-[#FFF0F4] text-[#594046] text-[12px] font-bold flex items-center justify-center gap-1.5 transition-all" onclick="WBAuth.login('Google'); alert('🌸 Masuk dengan Google berhasil!'); document.getElementById('modal-login').classList.add('hidden');" type="button">
<svg class="w-4 h-4" viewbox="0 0 24 24"><path d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.4l3.7 2.9C6.5 7.4 9 5 12 5z" fill="#EA4335"></path><path d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5.1 3.7-8.8z" fill="#4285F4"></path><path d="M5.6 14.7c-.2-.7-.4-1.5-.4-2.7s.1-2 .4-2.7L1.9 6.4C.7 8.8 0 10.8 0 12s.7 3.2 1.9 5.6l3.7-2.9z" fill="#FBBC05"></path><path d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.2 7.5 23 12 23z" fill="#34A853"></path></svg>
<span>Google</span>
</button>
<button class="cursor-pointer py-2.5 px-3 rounded-full border border-[#FBCFE8] hover:bg-[#FFF0F4] text-[#594046] text-[12px] font-bold flex items-center justify-center gap-1.5 transition-all" onclick="WBAuth.login('Apple'); alert('🌸 Masuk dengan Apple berhasil!'); document.getElementById('modal-login').classList.add('hidden');" type="button">
<svg class="w-4 h-4 fill-current" viewbox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.65-.79 1.1-1.89.98-3-.95.04-2.1 1.04-2.77 1.83-.59.68-1.11 1.8-1 2.89 1.07.08 2.14-.93 2.79-1.72z"></path></svg>
<span>Apple ID</span>
</button>
</div>
</div>
</div>
<!-- POPUP MODAL: SAVE PHOTO STRIP KEEPSAKE -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-save">
<div class="max-w-sm w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 text-center relative animate-in fade-in duration-200">
<button aria-label="Close Save Modal" class="cursor-pointer absolute top-4 right-4 w-8 h-8 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center" id="modal-save-close" type="button">
<span class="material-symbols-outlined text-[18px]">close</span>
</button>
<div class="w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center mx-auto mb-2">
<span class="material-symbols-outlined text-[24px]">verified</span>
</div>
<h3 class="font-serif text-[24px] font-bold text-[#970046]">Keepsake Ready!</h3>
<p class="text-[12.5px] text-[#594046] mb-4">Strip 4-cut hasil jepretan studio Anda siap! Lanjut ke halaman download untuk mengunduh (perlu masuk akun).</p>
<div class="flex flex-col gap-2">
<button class="cursor-pointer w-full py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-sm flex items-center justify-center gap-1.5 active:scale-95 transition-all" id="btn-download-strip" type="button">
<span class="material-symbols-outlined text-[18px]">download</span>
          Lihat &amp; Download Strip
        </button>
<button class="cursor-pointer w-full py-2.5 rounded-full border border-[#FBCFE8] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FFF0F4] transition-all" onclick="document.getElementById('modal-save').classList.add('hidden');" type="button">
          Tutup &amp; Ambil Lagi
        </button>
</div>
</div>
</div>
<!-- HIDDEN CANVAS FOR PHOTO STRIP DOWNLOAD GENERATION -->
<canvas id="hidden-canvas" style="display: none;"></canvas>
<!-- JAVASCRIPT LOGIC (DUMMY PHOTOBOOTH STUDIO MIRROR & STRIP CAPTURES) -->

<script>window.WB_WAND_SRC="{{ asset('images/whimsybooth/wb-wand.png') }}";window.WB_DOWNLOAD_URL="{{ url('/download') }}";</script>
<script src="{{ asset('js/wb-auth.js') }}"></script>
<script src="{{ asset('js/wb-wand.js') }}"></script>
<script>
  window.WB_AUTH = {
    logged_in: @json(auth()->check()),
    user: @json(auth()->check() ? ['name' => auth()->user()->name, 'email' => auth()->user()->email] : null),
    csrf: "{{ csrf_token() }}",
    urls: {
      login: "{{ url('/login') }}",
      register: "{{ url('/register') }}",
      logout: "{{ url('/logout') }}",
      google: "{{ url('/auth/google/redirect') }}"
    }
  };
</script>
<script src="{{ asset('js/wb-auth.js') }}"></script>
<script src="{{ asset('js/wb-lotus.js') }}"></script>
<script src="{{ asset('js/home-lotus.js') }}"></script>
<script>
/* Huruf interaktif: tiap huruf naik/timbul saat kursor (atau jari) melewatinya */
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-wb-pop]').forEach(function (el) {
    el.setAttribute('aria-label', el.textContent.replace(/\s+/g, ' ').trim());
    const tw = document.createTreeWalker(el, NodeFilter.SHOW_TEXT), nodes = [];
    while (tw.nextNode()) nodes.push(tw.currentNode);
    nodes.forEach(function (n) {
      if (!n.nodeValue.trim()) return;
      const frag = document.createDocumentFragment();
      n.nodeValue.split(/(\s+)/).forEach(function (part) {
        if (!part) return;
        if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
        const w = document.createElement('span'); w.className = 'wb-w'; w.setAttribute('aria-hidden', 'true');
        Array.from(part).forEach(function (c) { const s = document.createElement('span'); s.className = 'wb-ch'; s.textContent = c; w.appendChild(s); });
        frag.appendChild(w);
      });
      n.parentNode.replaceChild(frag, n);
    });
  });
  function pop(t) {
    if (!t || !t.classList || !t.classList.contains('wb-ch')) return;
    t.classList.add('wb-hot'); clearTimeout(t._wb); t._wb = setTimeout(function () { t.classList.remove('wb-hot'); }, 550);
  }
  document.addEventListener('pointerover', function (e) { if (e.pointerType !== 'touch') pop(e.target); });
  document.addEventListener('touchmove', function (e) { const t = e.touches[0]; if (t) pop(document.elementFromPoint(t.clientX, t.clientY)); }, { passive: true });
  document.addEventListener('touchstart', function (e) { const t = e.touches[0]; if (t) pop(document.elementFromPoint(t.clientX, t.clientY)); }, { passive: true });
});
</script>
<script>
/* Salju/kelopak pink naik dari bawah bunga hero */
document.addEventListener('DOMContentLoaded', function () {
  const host = document.getElementById('hero-lotus');
  if (!host || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const cv = document.createElement('canvas'); cv.className = 'wb-petals'; host.appendChild(cv);
  const ctx = cv.getContext('2d'); let W = 0, H = 0, dpr = 1, ps = [], run = true, last = 0;
  const COLORS = ['255,182,215', '249,168,212', '255,214,236', '255,255,255', '244,114,182'];
  function size() {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    W = cv.clientWidth; H = cv.clientHeight; cv.width = W * dpr; cv.height = H * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }
  function spawn(initial) {
    const petal = Math.random() < .35;
    return {
      x: W * (.2 + Math.random() * .6), y: initial ? H * (.3 + Math.random() * .7) : H * (.88 + Math.random() * .12),
      r: petal ? 3 + Math.random() * 3 : 1.4 + Math.random() * 2.6, petal: petal,
      vy: 18 + Math.random() * 34, sway: 8 + Math.random() * 22, ph: Math.random() * 6.28, fr: .6 + Math.random() * 1.2,
      rot: Math.random() * 6.28, vr: (Math.random() - .5) * 1.6, c: COLORS[(Math.random() * COLORS.length) | 0],
      a: .55 + Math.random() * .4, x0: 0
    };
  }
  function init() { size(); const n = Math.round(Math.min(46, Math.max(22, W / 9))); ps = []; for (let i = 0; i < n; i++) { const p = spawn(true); p.x0 = p.x; ps.push(p); } }
  function frame(t) {
    if (!run) return; requestAnimationFrame(frame);
    const dt = Math.min(.05, (t - last) / 1000 || .016); last = t;
    ctx.clearRect(0, 0, W, H);
    for (let i = 0; i < ps.length; i++) {
      const p = ps[i]; p.y -= p.vy * dt; p.ph += p.fr * dt; p.rot += p.vr * dt;
      const x = p.x + Math.sin(p.ph) * p.sway, life = p.y / H;
      if (p.y < -10) { ps[i] = spawn(false); continue; }
      const fade = Math.min(1, life * 2.2, (1 - life) * 6) * p.a;
      ctx.save(); ctx.translate(x, p.y); ctx.rotate(p.rot); ctx.globalAlpha = Math.max(0, fade);
      ctx.shadowColor = 'rgba(' + p.c + ',.95)'; ctx.shadowBlur = 8; ctx.fillStyle = 'rgba(' + p.c + ',1)';
      ctx.beginPath();
      if (p.petal) ctx.ellipse(0, 0, p.r * 1.5, p.r * .8, 0, 0, 6.283); else ctx.arc(0, 0, p.r, 0, 6.283);
      ctx.fill(); ctx.restore();
    }
  }
  init(); requestAnimationFrame(frame);
  window.addEventListener('resize', init);
  if ('IntersectionObserver' in window) new IntersectionObserver(function (e) {
    const on = e[0].isIntersecting; if (on && !run) { run = true; last = 0; requestAnimationFrame(frame); } else if (!on) run = false;
  }).observe(host);
});
</script>
</body></html>