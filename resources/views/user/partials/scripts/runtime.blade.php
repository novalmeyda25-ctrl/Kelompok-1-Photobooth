
{{-- KONFIGURASI WAND --}}
<script>
    window.WB_WAND_SRC = "{{ asset('images/whimsybooth/wb-wand.png') }}";
    window.WB_DOWNLOAD_URL = "{{ url('/download') }}";
    </script>
    
    {{-- KONFIGURASI AUTH --}}
    <script>
    window.WB_AUTH = {
        logged_in: @json(auth()->check()),
    
        user: @json(
            auth()->check()
            ? [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email
            ]
            : null
        ),
    
        csrf: "{{ csrf_token() }}",
    
        urls: {
            login: "{{ url('/login') }}",
            register: "{{ url('/register') }}",
            logout: "{{ url('/logout') }}",
            google: "{{ url('/auth/google/redirect') }}"
        }
    };
    </script>
    
    {{-- AUTH DAN ANIMASI EKSTERNAL --}}
    <script src="{{ asset('js/wb-auth.js') }}"></script>
    <script src="{{ asset('js/wb-wand.js') }}"></script>
    
    <script src="{{ asset('js/wb-lotus.js') }}"></script>
    <script src="{{ asset('js/home-lotus.js') }}"></script>
    
    {{-- ANIMASI HURUF INTERAKTIF --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    
        document.querySelectorAll('[data-wb-pop]').forEach(function (el) {
    
            el.setAttribute(
                'aria-label',
                el.textContent.replace(/\s+/g, ' ').trim()
            );
    
            const tw = document.createTreeWalker(
                el,
                NodeFilter.SHOW_TEXT
            );
    
            const nodes = [];
    
            while (tw.nextNode()) {
                nodes.push(tw.currentNode);
            }
    
            nodes.forEach(function (n) {
    
                if (!n.nodeValue.trim()) return;
    
                const frag = document.createDocumentFragment();
    
                n.nodeValue.split(/(\s+)/).forEach(function (part) {
    
                    if (!part) return;
    
                    if (/^\s+$/.test(part)) {
    
                        frag.appendChild(
                            document.createTextNode(' ')
                        );
    
                        return;
                    }
    
                    const w = document.createElement('span');
    
                    w.className = 'wb-w';
                    w.setAttribute('aria-hidden', 'true');
    
                    Array.from(part).forEach(function (c) {
    
                        const s = document.createElement('span');
    
                        s.className = 'wb-ch';
                        s.textContent = c;
    
                        w.appendChild(s);
    
                    });
    
                    frag.appendChild(w);
    
                });
    
                n.parentNode.replaceChild(frag, n);
    
            });
    
        });
    
        function pop(t) {
    
            if (
                !t ||
                !t.classList ||
                !t.classList.contains('wb-ch')
            ) return;
    
            t.classList.add('wb-hot');
    
            clearTimeout(t._wb);
    
            t._wb = setTimeout(function () {
    
                t.classList.remove('wb-hot');
    
            }, 550);
    
        }
    
        document.addEventListener('pointerover', function (e) {
    
            if (e.pointerType !== 'touch') {
                pop(e.target);
            }
    
        });
    
        document.addEventListener('touchmove', function (e) {
    
            const t = e.touches[0];
    
            if (t) {
                pop(
                    document.elementFromPoint(
                        t.clientX,
                        t.clientY
                    )
                );
            }
    
        }, { passive: true });
    
        document.addEventListener('touchstart', function (e) {
    
            const t = e.touches[0];
    
            if (t) {
                pop(
                    document.elementFromPoint(
                        t.clientX,
                        t.clientY
                    )
                );
            }
    
        }, { passive: true });
    
    });
    </script>
    
    {{-- ANIMASI KELopak PINK DI AREA LOTUS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const host = document.getElementById('hero-lotus');
    
        if (
            !host ||
            window.matchMedia('(prefers-reduced-motion: reduce)').matches
        ) return;
    
        const cv = document.createElement('canvas');
    
        cv.className = 'wb-petals';
    
        host.appendChild(cv);
    
        const ctx = cv.getContext('2d');
    
        let W = 0;
        let H = 0;
        let dpr = 1;
        let ps = [];
        let run = true;
        let last = 0;
    
        const COLORS = [
            '255,182,215',
            '249,168,212',
            '255,214,236',
            '255,255,255',
            '244,114,182'
        ];
    
        function size() {
    
            dpr = Math.min(
                window.devicePixelRatio || 1,
                2
            );
    
            W = cv.clientWidth;
            H = cv.clientHeight;
    
            cv.width = W * dpr;
            cv.height = H * dpr;
    
            ctx.setTransform(
                dpr, 0,
                0, dpr,
                0, 0
            );
    
        }
    
        function spawn(initial) {
    
            const petal = Math.random() < .35;
    
            return {
    
                x: W * (.2 + Math.random() * .6),
    
                y: initial
                    ? H * (.3 + Math.random() * .7)
                    : H * (.88 + Math.random() * .12),
    
                r: petal
                    ? 3 + Math.random() * 3
                    : 1.4 + Math.random() * 2.6,
    
                petal: petal,
    
                vy: 18 + Math.random() * 34,
    
                sway: 8 + Math.random() * 22,
    
                ph: Math.random() * 6.28,
    
                fr: .6 + Math.random() * 1.2,
    
                rot: Math.random() * 6.28,
    
                vr: (Math.random() - .5) * 1.6,
    
                c: COLORS[
                    (Math.random() * COLORS.length) | 0
                ],
    
                a: .55 + Math.random() * .4,
    
                x0: 0
            };
    
        }
    
        function init() {
    
            size();
    
            const n = Math.round(
                Math.min(
                    46,
                    Math.max(22, W / 9)
                )
            );
    
            ps = [];
    
            for (let i = 0; i < n; i++) {
    
                const p = spawn(true);
    
                p.x0 = p.x;
    
                ps.push(p);
    
            }
    
        }
    
        function frame(t) {
    
            if (!run) return;
    
            requestAnimationFrame(frame);
    
            const dt = Math.min(
                .05,
                (t - last) / 1000 || .016
            );
    
            last = t;
    
            ctx.clearRect(0, 0, W, H);
    
            for (let i = 0; i < ps.length; i++) {
    
                const p = ps[i];
    
                p.y -= p.vy * dt;
                p.ph += p.fr * dt;
                p.rot += p.vr * dt;
    
                const x = p.x + Math.sin(p.ph) * p.sway;
                const life = p.y / H;
    
                if (p.y < -10) {
    
                    ps[i] = spawn(false);
    
                    continue;
    
                }
    
                const fade = Math.min(
                    1,
                    life * 2.2,
                    (1 - life) * 6
                ) * p.a;
    
                ctx.save();
    
                ctx.translate(x, p.y);
                ctx.rotate(p.rot);
    
                ctx.globalAlpha = Math.max(0, fade);
    
                ctx.shadowColor = 'rgba(' + p.c + ',.95)';
                ctx.shadowBlur = 8;
    
                ctx.fillStyle = 'rgba(' + p.c + ',1)';
    
                ctx.beginPath();
    
                if (p.petal) {
    
                    ctx.ellipse(
                        0, 0,
                        p.r * 1.5,
                        p.r * .8,
                        0, 0, 6.283
                    );
    
                } else {
    
                    ctx.arc(
                        0, 0,
                        p.r,
                        0,
                        6.283
                    );
    
                }
    
                ctx.fill();
    
                ctx.restore();
    
            }
    
        }
    
        init();
    
        requestAnimationFrame(frame);
    
        window.addEventListener('resize', init);
    
        if ('IntersectionObserver' in window) {
    
            new IntersectionObserver(function (e) {
    
                const on = e[0].isIntersecting;
    
                if (on && !run) {
    
                    run = true;
                    last = 0;
    
                    requestAnimationFrame(frame);
    
                } else if (!on) {
    
                    run = false;
    
                }
    
            }).observe(host);
    
        }
    
    });
    </script>
    
    {{-- PENGAKTIFAN KAMERA --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const video = document.getElementById('camera-video');
    
        const allowButton = document.getElementById('btn-allow-camera');
        const dismissButton = document.getElementById('btn-dismiss-camera');
        const tryAgainButton = document.getElementById('btn-try-again-camera');
        const reopenButton = document.getElementById('btn-reopen-permission');
    
        const permissionModal = document.getElementById('camera-permission-modal');
        const fallbackModal = document.getElementById('camera-dismissed-fallback');
    
        const indicatorText = document.getElementById('studio-indicator-text');
        const indicatorDot = document.getElementById('studio-indicator-dot');
        const mirrorBadge = document.getElementById('viewfinder-mirror-badge');
    
        let cameraStream = null;
    
        async function startCamera() {
    
            try {
    
                if (
                    !navigator.mediaDevices ||
                    !navigator.mediaDevices.getUserMedia
                ) {
                    throw new Error('Browser tidak mendukung kamera.');
                }
    
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
    
                video.srcObject = cameraStream;
    
                await video.play();
    
                // Tutup popup izin
                permissionModal.classList.add('hidden');
    
                // Tutup fallback
                fallbackModal.classList.add('hidden');
                fallbackModal.classList.remove('flex');
    
                // Update status
                indicatorText.textContent = 'CAMERA READY';
    
                indicatorDot.classList.remove('bg-amber-400');
                indicatorDot.classList.add('bg-green-500');
    
                mirrorBadge.textContent = 'Camera Live';
    
            } catch (error) {
    
                console.error('Camera error:', error);
    
                permissionModal.classList.add('hidden');
    
                fallbackModal.classList.remove('hidden');
                fallbackModal.classList.add('flex');
    
                indicatorText.textContent = 'CAMERA UNAVAILABLE';
    
                indicatorDot.classList.remove('bg-amber-400');
                indicatorDot.classList.add('bg-red-500');
    
                mirrorBadge.textContent = 'Camera Unavailable';
    
            }
    
        }
    
        // Tombol Allow Camera
        allowButton.addEventListener('click', function () {
            startCamera();
        });
    
        // Tombol Try Again
        tryAgainButton.addEventListener('click', function () {
            startCamera();
        });
    
        // Tombol Izin Akses Kamera
        reopenButton.addEventListener('click', function () {
    
            permissionModal.classList.remove('hidden');
    
            fallbackModal.classList.add('hidden');
            fallbackModal.classList.remove('flex');
    
        });
    
        // Tombol Dismiss
        dismissButton.addEventListener('click', function () {
    
            permissionModal.classList.add('hidden');
    
            fallbackModal.classList.remove('hidden');
            fallbackModal.classList.add('flex');
    
            indicatorText.textContent = 'CAMERA DISABLED';
    
            mirrorBadge.textContent = 'Camera Permission Needed';
    
        });     
    }); 
    </script>
    