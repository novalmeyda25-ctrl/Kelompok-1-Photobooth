
<html class="scroll-smooth" lang="en">
<head>

<meta charset="utf-8"/>

<script>
try {
    if (sessionStorage.getItem("wbArrive") === "1") {
        sessionStorage.removeItem("wbArrive");
        document.documentElement.classList.add("wb-arriving");

        setTimeout(function () {
            document.documentElement.classList.remove("wb-arriving");
        }, 8000);
    }
} catch(e) {}
</script>

<style>
html.wb-arriving::before {
    content: "";
    position: fixed;
    inset: 0;
    z-index: 99999;
    pointer-events: none;
    background: radial-gradient(circle at 50% 50%,#fff3fa,#ffd6ec 60%,#e8d4ff);
    opacity: 1;
    transition: opacity .9s ease;
}

html.wb-arriving.wb-veil-off::before {
    opacity: 0;
}
</style>

<meta content="width=device-width, initial-scale=1.0" name="viewport"/>

<title>WHIMSHYBOOTH - Interactive Real Webcam Studio &amp; Keepsake Strips</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&amp;family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>

<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

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

<link rel="icon" type="image/png"
href="{{ asset('images/whimsybooth/fairy-logo.png') }}">

{{-- Konfigurasi template photobooth --}}
<script>
window.WB_TPL_BASE = "{{ asset('img/templates') }}";
window.WB_TEMPLATES = @json($templates ?? null);
</script>

{{-- Library template --}}
<script src="{{ asset('js/wb-templates.js') }}"></script>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<link rel="stylesheet" href="{{ asset('css/wb-lotus.css') }}">

{{-- Efek visual hero dan tulisan --}}
<style>

/* Cahaya pink-putih di sekitar bunga hero */
#hero-lotus {
    position: relative;
    isolation: isolate;
    animation: wbLotusGlow 4.8s ease-in-out infinite;
}

#hero-lotus::before {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    width: 94%;
    aspect-ratio: 1/1;
    transform: translate(-50%,-50%);
    border-radius: 50%;
    z-index: -1;
    pointer-events: none;

    background: radial-gradient(
        circle,
        rgba(255,255,255,.9) 0%,
        rgba(255,226,242,.7) 26%,
        rgba(249,168,212,.32) 50%,
        rgba(249,168,212,0) 72%
    );

    filter: blur(16px);
    animation: wbHalo 4.8s ease-in-out infinite;
}

@keyframes wbLotusGlow {
    0%,100% {
        filter:
        drop-shadow(0 0 6px rgba(255,255,255,.85))
        drop-shadow(0 0 16px rgba(255,160,210,.42));
    }

    50% {
        filter:
        drop-shadow(0 0 10px rgba(255,255,255,1))
        drop-shadow(0 0 28px rgba(255,140,200,.62));
    }
}

@keyframes wbHalo {
    0%,100% {
        opacity: .7;
        transform: translate(-50%,-50%) scale(.95);
    }

    50% {
        opacity: 1;
        transform: translate(-50%,-50%) scale(1.07);
    }
}

@media (prefers-reduced-motion:reduce) {
    #hero-lotus,
    #hero-lotus::before {
        animation: none;
    }
}

/* Cahaya pink mengikuti bentuk huruf */
.wb-glow-text {
    text-shadow:
    0 0 4px rgba(255,255,255,.9),
    0 0 10px rgba(249,168,212,.85),
    0 0 20px rgba(244,114,182,.55);

    animation: wbTextGlow 4s ease-in-out infinite;
}

@keyframes wbTextGlow {
    0%,100% {
        text-shadow:
        0 0 3px rgba(255,255,255,.85),
        0 0 8px rgba(249,168,212,.7),
        0 0 16px rgba(244,114,182,.4);
    }

    50% {
        text-shadow:
        0 0 5px rgba(255,255,255,1),
        0 0 13px rgba(249,168,212,.95),
        0 0 26px rgba(244,114,182,.7);
    }
}

@media (prefers-reduced-motion:reduce) {
    .wb-glow-text {
        animation: none;
    }
}

/* Huruf interaktif */
.wb-w {
    display: inline-block;
    white-space: nowrap;
}

.wb-ch {
    display: inline-block;
    transition:
    transform .35s cubic-bezier(.34,1.8,.5,1),
    color .3s,
    text-shadow .3s;

    will-change: transform;
    cursor: default;
}

.wb-ch.wb-hot {
    transform: translateY(-10px) scale(1.28) rotate(-4deg);
    color: #E11D48;

    text-shadow:
    0 0 6px rgba(255,255,255,.95),
    0 0 14px rgba(249,168,212,.95),
    0 0 28px rgba(244,114,182,.8),
    0 6px 10px rgba(190,24,93,.25);
}

@media (prefers-reduced-motion:reduce) {
    .wb-ch,
    .wb-ch.wb-hot {
        transition: none;
        transform: none;
    }
}

#hero-lotus .wb-petals {
    position: absolute;
    inset: -8% 0 0 0;
    width: 100%;
    height: 108%;
    pointer-events: none;
    z-index: 3;
}

</style>

</head>
