document.addEventListener("DOMContentLoaded", () => {
    // =====================================
    // DUMMY PHOTO (dipakai jika ada slot yang belum difoto saat menyimpan)
    // =====================================
    const dummyPoseImages = [
        'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=600&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=600&auto=format&fit=crop'
    ];

    // =====================================
    // STATE
    // =====================================
    let currentSlot = 1;
    let totalSnapped = 0;
    let timerDuration = 3;
    let isMirrorOn = true;
    let isFlashOn = false;
    let isCameraAllowed = false;
    let currentFilterCss = 'none';
    let currentFilterName = 'Original';
    let currentThemeFrameName = 'Garden';

    // key = nomor slot (1..slotCount). Jumlah slot ikut template yang dipilih.
    const capturedImages = {};
    let slotCount = 4;
    let currentTemplate = null;

    // =====================================
    // DOM ELEMENTS
    // =====================================
    const cameraVideo = document.getElementById('camera-video');
    let cameraStream = null;
    const countdownLayer = document.getElementById('countdown-layer');
    const countdownNumber = document.getElementById('countdown-number');
    const flashEffect = document.getElementById('flash-effect');
    const snappedCountEl = document.getElementById('snapped-count');
    const shutterCaption = document.getElementById('shutter-caption');
    const btnToggleMirror = document.getElementById('btn-toggle-mirror');
    const lblMirror = document.getElementById('lbl-mirror');
    const mirrorBadge = document.getElementById('viewfinder-mirror-badge');
    const camLensDot = document.getElementById('cam-lens-dot');
    const camLensTitle = document.getElementById('cam-lens-title');
    const camLensMode = document.getElementById('cam-lens-mode');
    const mirrorDot = document.getElementById('viewfinder-mirror-dot');
    const studioIndicatorDot = document.getElementById('studio-indicator-dot');
    const studioIndicatorText = document.getElementById('studio-indicator-text');

    // =====================================
    // MODALS
    // =====================================
    const permissionModal = document.getElementById('camera-permission-modal');
    const dismissedFallback = document.getElementById('camera-dismissed-fallback');
    const btnAllowCamera = document.getElementById('btn-allow-camera');
    const btnDismissCamera = document.getElementById('btn-dismiss-camera');
    const btnTryAgainCamera = document.getElementById('btn-try-again-camera');
    const btnReopenPermission = document.getElementById('btn-reopen-permission');
    const modalGuide = document.getElementById('modal-guide');
    const modalLogin = document.getElementById('modal-login');
    const modalSave = document.getElementById('modal-save');

    // =====================================
    // MIRROR VIEW
    // =====================================
    function updateMirrorView() {
        if (cameraVideo) {
            cameraVideo.style.setProperty(
                'transform',
                isMirrorOn ? 'scaleX(-1)' : 'none',
                'important'
            );
        }

        if (lblMirror) {
            lblMirror.innerText = isMirrorOn ? 'Mirror: On' : 'Mirror: Off';
        }

        if (isCameraAllowed && mirrorBadge) {
            mirrorBadge.innerText =
                isMirrorOn ? 'Studio Mirror Active' : 'Direct View Active';
        }
    }

    // =====================================
    // CAMERA PERMISSION + CAMERA DEVICE
    // =====================================
    async function setCameraAllowedState() {
        try {
            if (!cameraVideo) {
                throw new Error('Elemen video dengan id="camera-video" tidak ditemukan.');
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Browser tidak menyediakan akses kamera. Gunakan localhost atau HTTPS.');
            }

            // Hentikan stream sebelumnya agar tidak ada dua sesi kamera aktif.
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'user' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });

            cameraVideo.srcObject = cameraStream;
            cameraVideo.muted = true;
            cameraVideo.playsInline = true;
            cameraVideo.style.filter = currentFilterCss;
            await cameraVideo.play();

            // Perbarui tampilan jika kamera terputus.
            cameraStream.getVideoTracks().forEach(track => {
                track.addEventListener('ended', () => {
                    isCameraAllowed = false;
                    if (cameraVideo) cameraVideo.srcObject = null;
                    if (camLensTitle) camLensTitle.innerText = 'CAMERA DISCONNECTED';
                    if (studioIndicatorText) studioIndicatorText.innerText = 'CAMERA DISCONNECTED';
                    if (shutterCaption) {
                        shutterCaption.innerText = 'Koneksi kamera terputus. Tekan Coba Lagi untuk menghubungkan kembali.';
                    }
                }, { once: true });
            });

            isCameraAllowed = true;
            updateMirrorView();

            permissionModal?.classList.add('hidden');
            dismissedFallback?.classList.add('hidden');
            dismissedFallback?.classList.remove('flex');

            if (camLensDot) {
                camLensDot.className = 'w-2 h-2 rounded-full bg-emerald-500 animate-pulse';
            }
            if (camLensTitle) camLensTitle.innerText = 'STUDIO CAMERA ACTIVE';
            if (camLensMode) camLensMode.innerText = 'ready to snap';
            if (studioIndicatorDot) {
                studioIndicatorDot.className = 'w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]';
            }
            if (studioIndicatorText) studioIndicatorText.innerText = 'READY TO CAPTURE';
            if (mirrorDot) mirrorDot.className = 'w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping';
            if (shutterCaption) {
                shutterCaption.innerText = 'Kamera berhasil aktif! Silakan berpose dan ambil foto.';
            }

            console.info('WHIMSYBOOTH: kamera berhasil diaktifkan.');
        } catch (error) {
            console.error('WHIMSYBOOTH: gagal membuka kamera:', error);

            cameraStream?.getTracks().forEach(track => track.stop());
            cameraStream = null;
            if (cameraVideo) cameraVideo.srcObject = null;
            isCameraAllowed = false;

            permissionModal?.classList.add('hidden');
            dismissedFallback?.classList.remove('hidden');
            dismissedFallback?.classList.add('flex');

            if (camLensDot) camLensDot.className = 'w-2 h-2 rounded-full bg-rose-500';
            if (camLensTitle) camLensTitle.innerText = 'CAMERA NOT AVAILABLE';
            if (camLensMode) camLensMode.innerText = 'access failed';
            if (studioIndicatorDot) {
                studioIndicatorDot.className = 'w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_8px_#f43f5e]';
            }
            if (studioIndicatorText) studioIndicatorText.innerText = 'CAMERA NOT AVAILABLE';
            if (mirrorDot) mirrorDot.className = 'w-1.5 h-1.5 rounded-full bg-rose-500';
            if (mirrorBadge) mirrorBadge.innerText = 'Camera Access Failed';
            if (shutterCaption) shutterCaption.innerText = 'Kamera gagal dibuka: ' + error.message;

            alert('Kamera gagal dibuka: ' + error.message);
        }
    }

    function setCameraDismissedState() {
        cameraStream?.getTracks().forEach(track => track.stop());
        cameraStream = null;
        if (cameraVideo) cameraVideo.srcObject = null;
        isCameraAllowed = false;

        permissionModal?.classList.add('hidden');
        dismissedFallback?.classList.remove('hidden');
        dismissedFallback?.classList.add('flex');

        if (camLensDot) camLensDot.className = 'w-2 h-2 rounded-full bg-rose-500';
        if (camLensTitle) camLensTitle.innerText = 'CAMERA LENS IN REPOSE';
        if (camLensMode) camLensMode.innerText = 'access denied';
        if (studioIndicatorDot) {
            studioIndicatorDot.className = 'w-2 h-2 rounded-full bg-rose-500 shadow-[0_0_8px_#f43f5e]';
        }
        if (studioIndicatorText) studioIndicatorText.innerText = 'CAMERA IN REPOSE';
        if (mirrorDot) mirrorDot.className = 'w-1.5 h-1.5 rounded-full bg-rose-500';
        if (mirrorBadge) mirrorBadge.innerText = 'Camera Access Dismissed';
        if (shutterCaption) {
            shutterCaption.innerText = 'Akses kamera ditolak. Tekan Izinkan Kamera untuk mencoba lagi.';
        }
    }

    function openCameraPermissionDialog() {
        dismissedFallback?.classList.add('hidden');
        dismissedFallback?.classList.remove('flex');
        permissionModal?.classList.remove('hidden');

        if (camLensDot) camLensDot.className = 'w-2 h-2 rounded-full bg-amber-400 animate-pulse';
        if (camLensTitle) camLensTitle.innerText = 'AWAITING CAMERA ACCESS';
        if (camLensMode) camLensMode.innerText = 'permission dialog';
        if (studioIndicatorDot) {
            studioIndicatorDot.className = 'w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_#f59e0b]';
        }
        if (studioIndicatorText) studioIndicatorText.innerText = 'REQUESTING PERMISSION';
        if (mirrorDot) mirrorDot.className = 'w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping';
        if (mirrorBadge) mirrorBadge.innerText = 'Awaiting Camera Permission';
    }

    btnAllowCamera?.addEventListener('click', event => {
        event.preventDefault();
        setCameraAllowedState();
    });

    btnDismissCamera?.addEventListener('click', event => {
        event.preventDefault();
        setCameraDismissedState();
    });

    btnTryAgainCamera?.addEventListener('click', event => {
        event.preventDefault();
        setCameraAllowedState();
    });

    btnReopenPermission?.addEventListener('click', event => {
        event.preventDefault();
        openCameraPermissionDialog();
    });

    // =====================================
    // MIRROR TOGGLE
    // =====================================
    btnToggleMirror?.addEventListener('click', () => {
        isMirrorOn = !isMirrorOn;
        updateMirrorView();
    });

    // =====================================
    // FLASH TOGGLE
    // =====================================
    document.getElementById('btn-toggle-flash')
        ?.addEventListener('click', () => {
            isFlashOn = !isFlashOn;

            const flashLabel = document.getElementById('lbl-flash');

            if (flashLabel) {
                flashLabel.innerHTML = isFlashOn
                    ? 'Flash <span class="text-[#BE185D] font-bold">On</span>'
                    : 'Flash <span class="text-[#8D7075] font-normal">Off</span>';
            }
        });

    // =====================================
    // TIMER SELECTOR
    // =====================================
    document.querySelectorAll('.timer-opt').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.timer-opt').forEach(b => {
                b.className =
                    'timer-opt px-3 py-1 rounded-full text-[11.5px] font-medium text-[#8D7075] hover:text-[#970046] cursor-pointer';
            });

            this.className =
                'timer-opt px-3 py-1 rounded-full text-[11.5px] font-bold bg-[#BE185D] text-white shadow-xs cursor-pointer';

            timerDuration = parseInt(this.dataset.sec, 10) || 3;
        });
    });

    // =====================================
    // FILTER SELECTION
    // =====================================
    document.querySelectorAll('.filter-item').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('.filter-item').forEach(filter => {
                filter.classList.remove(
                    'border-2',
                    'border-[#BE185D]',
                    'bg-[#FFE4E8]/60'
                );

                filter.classList.add(
                    'border',
                    'border-[#FCE7F3]',
                    'bg-white'
                );

                const label = filter.querySelector('span');

                if (label) {
                    label.classList.remove(
                        'font-bold',
                        'text-[#970046]'
                    );

                    label.classList.add(
                        'font-medium',
                        'text-[#594046]'
                    );
                }
            });

            this.classList.remove(
                'border',
                'border-[#FCE7F3]',
                'bg-white'
            );

            this.classList.add(
                'border-2',
                'border-[#BE185D]',
                'bg-[#FFE4E8]/60'
            );

            const selectedLabel = this.querySelector('span');

            if (selectedLabel) {
                selectedLabel.classList.remove(
                    'font-medium',
                    'text-[#594046]'
                );

                selectedLabel.classList.add(
                    'font-bold',
                    'text-[#970046]'
                );
            }

            currentFilterCss = this.dataset.filterCss || 'none';
            currentFilterName = this.dataset.title || 'Original';

            if (cameraVideo) {
                cameraVideo.style.filter = currentFilterCss;
            }

            document.querySelectorAll('.slot-photo').forEach(photo => {
                photo.style.filter = currentFilterCss;
            });

            const moodTag = document.getElementById('cam-mood-tag');

            if (moodTag) {
                moodTag.innerText =
                    currentFilterName.toUpperCase() + ' MOOD';
            }
        });
    });

    // =====================================
    // FILTER DRAG WITH MOUSE
    // =====================================
    const filterScroll = document.querySelector('.filter-scroll');

    if (filterScroll) {
        let isDragging = false;
        let hasMoved = false;
        let startX = 0;
        let scrollStart = 0;

        filterScroll.addEventListener('mousedown', event => {
            if (event.button !== 0) return;

            isDragging = true;
            hasMoved = false;

            startX = event.pageX;
            scrollStart = filterScroll.scrollLeft;

            filterScroll.classList.add('dragging');
        });

        document.addEventListener('mousemove', event => {
            if (!isDragging) return;

            const distance = event.pageX - startX;

            if (Math.abs(distance) > 5) {
                hasMoved = true;
            }

            if (hasMoved) {
                event.preventDefault();
                filterScroll.scrollLeft = scrollStart - distance;
            }
        });

        document.addEventListener('mouseup', () => {
            if (!isDragging) return;

            isDragging = false;
            filterScroll.classList.remove('dragging');

            if (hasMoved) {
                filterScroll.dataset.dragged = 'true';

                setTimeout(() => {
                    delete filterScroll.dataset.dragged;
                }, 100);
            }
        });

        filterScroll.addEventListener('click', event => {
            if (filterScroll.dataset.dragged === 'true') {
                event.preventDefault();
                event.stopPropagation();
            }
        }, true);
    }

    // =====================================
    // SUARA (dibuat dengan Web Audio, tanpa file mp3)
    // Matikan semua suara: window.WB_SOUND = false
    // =====================================
    let audioCtx = null;

    function getAudio() {
        if (window.WB_SOUND === false) return null;

        try {
            audioCtx = audioCtx || new (window.AudioContext || window.webkitAudioContext)();

            if (audioCtx.state === 'suspended') audioCtx.resume();
        } catch (e) {
            return null;
        }

        return audioCtx;
    }

    // bunyi "tik" hitung mundur
    function playTick(final) {
        const ac = getAudio();
        if (!ac) return;

        const t = ac.currentTime;
        const osc = ac.createOscillator();
        const gain = ac.createGain();

        osc.type = 'sine';
        osc.frequency.value = final ? 1175 : 880;

        gain.gain.setValueAtTime(0.0001, t);
        gain.gain.exponentialRampToValueAtTime(0.18, t + 0.01);
        gain.gain.exponentialRampToValueAtTime(0.0001, t + 0.14);

        osc.connect(gain).connect(ac.destination);
        osc.start(t);
        osc.stop(t + 0.16);
    }

    // bunyi shutter kamera: dua klik mekanis (buka-tutup) + sedikit "thunk"
    function playShutter() {
        const ac = getAudio();
        if (!ac) return;

        const t = ac.currentTime;
        const len = Math.floor(ac.sampleRate * 0.09);
        const buf = ac.createBuffer(1, len, ac.sampleRate);
        const data = buf.getChannelData(0);

        for (let i = 0; i < len; i++) {
            data[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, 3);
        }

        [0, 0.085].forEach((offset, idx) => {
            const src = ac.createBufferSource();
            const hp = ac.createBiquadFilter();
            const gain = ac.createGain();

            src.buffer = buf;
            hp.type = 'bandpass';
            hp.frequency.value = idx === 0 ? 2600 : 1800;
            hp.Q.value = 0.9;

            gain.gain.setValueAtTime(idx === 0 ? 0.9 : 0.65, t + offset);

            src.connect(hp).connect(gain).connect(ac.destination);
            src.start(t + offset);
        });

        const osc = ac.createOscillator();
        const g = ac.createGain();

        osc.type = 'triangle';
        osc.frequency.setValueAtTime(190, t);
        osc.frequency.exponentialRampToValueAtTime(70, t + 0.1);

        g.gain.setValueAtTime(0.3, t);
        g.gain.exponentialRampToValueAtTime(0.0001, t + 0.12);

        osc.connect(g).connect(ac.destination);
        osc.start(t);
        osc.stop(t + 0.14);
    }

    // =====================================
    // CAPTURE PHOTO
    // =====================================
    const captureShutterBtn =
        document.getElementById('btn-capture-shutter');

    captureShutterBtn?.addEventListener('click', () => {
        if (!isCameraAllowed) {
            openCameraPermissionDialog();
            return;
        }

        if (totalSnapped >= slotCount) {
            alert(
                `🌸 Semua ${slotCount} slot foto sudah terisi! Klik "Save photo strip" untuk menyimpan atau "Retake all" untuk mengulang.`
            );
            return;
        }

        let count = timerDuration;

        countdownLayer?.classList.remove('hidden');

        if (countdownNumber) {
            countdownNumber.innerText = count;
        }

        playTick(false);

        const timerInterval = setInterval(() => {
            count--;

            if (count > 0) {
                if (countdownNumber) {
                    countdownNumber.innerText = count;
                }

                playTick(count === 1);
            } else {
                clearInterval(timerInterval);
                countdownLayer?.classList.add('hidden');
                playShutter();

                if (flashEffect) {
                    flashEffect.style.opacity = isFlashOn ? '1' : '0.85';

                    setTimeout(() => {
                        flashEffect.style.opacity = '0';
                    }, 220);
                }

                const captured = captureSnapshot(currentSlot);

                if (captured) {
                    advanceSlot();
                }
            }
        }, 750);
    });

    // =====================================
    // CAPTURE SNAPSHOT
    // =====================================
    function captureSnapshot(slotIndex) {
        const video = document.getElementById('camera-video');

        if (!video || !video.srcObject) {
            alert('Kamera belum aktif. Klik Izinkan Kamera terlebih dahulu.');
            return false;
        }

        if (!video.videoWidth || !video.videoHeight) {
            alert('Kamera belum siap. Tunggu sebentar lalu coba lagi.');
            return false;
        }

        const canvas = document.getElementById('hidden-canvas');

        if (!canvas) {
            console.error('hidden-canvas tidak ditemukan.');
            return false;
        }

        const width = video.videoWidth;
        const height = video.videoHeight;

        canvas.width = width;
        canvas.height = height;

        const ctx = canvas.getContext('2d');

        // Mirror mengikuti tampilan kamera
        if (isMirrorOn) {
            ctx.save();
            ctx.translate(width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, width, height);
            ctx.restore();
        } else {
            ctx.drawImage(video, 0, 0, width, height);
        }

        const imageUrl = canvas.toDataURL('image/png');

        capturedImages[slotIndex] = imageUrl;

        const slotEl = document.querySelector(
            `.strip-slot[data-index="${slotIndex}"]`
        );

        if (slotEl) {
            const textEl = slotEl.querySelector('.slot-text');
            const photoEl = slotEl.querySelector('.slot-photo');

            if (photoEl) {
                photoEl.style.backgroundImage = `url("${imageUrl}")`;
                photoEl.style.filter = currentFilterCss;
                photoEl.classList.remove('hidden');
            }

            textEl?.classList.add('hidden');
            slotEl.dataset.filled = 'true';

            totalSnapped = Math.min(slotCount, totalSnapped + 1);

            if (snappedCountEl) {
                snappedCountEl.innerText = totalSnapped;
            }
        }

        if (shutterCaption) {
            shutterCaption.innerHTML =
                `<span class="material-symbols-outlined text-[14px] text-[#BE185D]">check_circle</span> Pose 0${slotIndex} captured with fairy charm!`;
        }

        return true;
    }

    // =====================================
    // ADVANCE SLOT
    // =====================================
    function advanceSlot() {
        const emptySlots = [];

        document.querySelectorAll('.strip-slot').forEach(slot => {
            if (!slot.dataset.filled || slot.dataset.filled === 'false') {
                emptySlots.push(parseInt(slot.dataset.index, 10));
            }
        });

        if (emptySlots.length > 0) {
            currentSlot = emptySlots[0];
            markCurrent();
        } else {
            markCurrent();

            setTimeout(() => {
                modalSave?.classList.remove('hidden');
            }, 500);
        }
    }

    // =====================================
    // TEMPLATE (FRAME) + STRIP BUILDER
    // Jumlah slot foto mengikuti template (1 / 2 / 3 / 4 / ...)
    // Daftar template: WBTpl.list()  (dari wb-templates.js / window.WB_TEMPLATES)
    // =====================================
    const stripCanvas = document.getElementById('main-strip-canvas');
    const snappedTotalEl = document.getElementById('snapped-total');
    const templateList = window.WBTpl ? window.WBTpl.list() : [];
    const templateById = {};

    templateList.forEach(t => { templateById[t.id] = t; });

    function esc(text) {
        const d = document.createElement('div');
        d.textContent = text == null ? '' : String(text);
        return d.innerHTML;
    }

    const ORDINALS = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth'];

    function slotLabel(i, n) {
        if (n === 1) return 'Your pose';
        if (i === n - 1) return 'Your final pose';
        return `Your ${ORDINALS[i] || 'next'} pose`;
    }

    function slotInner(i, n, compact) {
        const num = String(i + 1).padStart(2, '0');

        return `
            <div class="slot-text flex flex-col items-center justify-center">
                <span class="font-serif ${compact ? 'text-[15px]' : 'text-[20px]'} text-[#970046] font-medium leading-tight">${num}</span>
                <span class="${compact ? 'text-[9px]' : 'text-[11px]'} text-[#8D7075] mt-0.5">${slotLabel(i, n)}</span>
            </div>
            <div class="slot-photo absolute inset-0 ${compact ? '' : 'rounded-xl'} bg-cover bg-center hidden transition-all duration-300"></div>`;
    }

    // Tandai slot yang sedang aktif (ring untuk strip biasa, kotak highlight untuk template gambar)
    function markCurrent() {
        document.querySelectorAll('.strip-slot').forEach(slot => {
            slot.classList.remove('ring-2', 'ring-[#BE185D]');
        });

        const slot = document.querySelector(
            `.strip-slot[data-index="${currentSlot}"]`
        );

        const highlight = document.getElementById('slot-highlight');

        if (highlight) {
            if (slot) {
                highlight.style.left = slot.style.left;
                highlight.style.top = slot.style.top;
                highlight.style.width = slot.style.width;
                highlight.style.height = slot.style.height;
                highlight.style.transform = slot.style.transform;
                highlight.classList.remove('hidden');
            } else {
                highlight.classList.add('hidden');
            }
        } else {
            slot?.classList.add('ring-2', 'ring-[#BE185D]');
        }
    }

    function buildStrip() {
        if (!stripCanvas) {
            console.error('Elemen #main-strip-canvas tidak ditemukan di halaman.');
            return;
        }

        if (!currentTemplate) return;

        const t = currentTemplate;
        const n = t.slots.length;
        let html = '';

        if (t.kind === 'classic') {
            stripCanvas.className =
                'w-full px-5 py-4 rounded-2xl border-2 border-[#FBCFE8] shadow-inner flex flex-col items-center transition-all duration-300';

            stripCanvas.style.backgroundColor = t.bg;

            let slots = '';

            for (let i = 0; i < n; i++) {
                slots += `
                    <div class="strip-slot relative w-full aspect-[4/2.9] rounded-xl bg-[#FFE4E8] border border-[#FBCFE8] flex flex-col items-center justify-center text-center p-2 cursor-pointer hover:border-[#BE185D] transition-all overflow-hidden" data-index="${i + 1}">
                        ${slotInner(i, n, false)}
                    </div>`;
            }

            html = `
                <div class="flex items-center justify-center gap-1.5 mb-2.5 text-[#970046] text-[12px] font-medium tracking-wide">
                    <span class="text-[12px] text-[#E11D48]">✿</span>
                    <span class="font-bold lowercase">whimshybooth</span>
                    <span class="text-[12px] text-[#E11D48]">✿</span>
                </div>
                <div class="w-full flex flex-col gap-2.5">${slots}</div>
                <div class="w-full flex items-center justify-between text-[#8D7075] text-[9.5px] uppercase tracking-[0.15em] mt-3.5 pt-1.5 border-t border-[#FBCFE8]">
                    <span>MADE WITH A LITTLE MAGIC</span>
                    <span class="text-[12px] text-[#BE185D]">♡</span>
                </div>`;
        } else {
            stripCanvas.className =
                'w-full rounded-2xl border-2 border-[#FBCFE8] shadow-inner overflow-hidden transition-all duration-300';

            stripCanvas.style.backgroundColor = '#FFFFFF';

            const imgTag = (z) => `
                <img src="${esc(t.image)}" alt="${esc(t.name)}" draggable="false"
                     class="absolute inset-0 w-full h-full pointer-events-none select-none"
                     style="z-index:${z}">`;

            let slots = '';

            for (let i = 0; i < n; i++) {
                const b = window.WBTpl.slotBox(t, i);

                slots += `
                    <div class="strip-slot absolute bg-[#FFE4E8]/90 flex flex-col items-center justify-center text-center cursor-pointer overflow-hidden"
                         data-index="${i + 1}"
                         style="left:${b.left};top:${b.top};width:${b.width};height:${b.height};transform:rotate(${b.rot}deg);z-index:1">
                        ${slotInner(i, n, true)}
                    </div>`;
            }

            html = `
                <div class="relative w-full" style="aspect-ratio:${t.width}/${t.height}">
                    ${t.layer === 'under' ? imgTag(0) : ''}
                    ${slots}
                    ${t.layer === 'under' ? '' : imgTag(2)}
                    <div id="slot-highlight" class="absolute pointer-events-none hidden"
                         style="z-index:3;border:3px solid #BE185D;box-shadow:0 0 0 2px rgba(255,255,255,.85),0 0 16px rgba(190,24,93,.55)"></div>
                </div>`;
        }

        stripCanvas.innerHTML = html;

        // pulihkan foto yang sudah diambil (kalau user ganti template di tengah sesi)
        for (let i = 1; i <= n; i++) {
            const url = capturedImages[i];
            if (!url) continue;

            const slotEl = stripCanvas.querySelector(`.strip-slot[data-index="${i}"]`);
            const photoEl = slotEl?.querySelector('.slot-photo');

            if (!photoEl) continue;

            photoEl.style.backgroundImage = `url('${url}')`;
            photoEl.style.filter = currentFilterCss;
            photoEl.classList.remove('hidden');
            slotEl.querySelector('.slot-text')?.classList.add('hidden');
            slotEl.dataset.filled = 'true';
        }
    }

    function applyTemplate(t) {
        currentTemplate = t;
        slotCount = t.slots.length;
        currentThemeFrameName = t.name;

        // buang foto yang slot-nya tidak ada di template baru
        Object.keys(capturedImages).forEach(key => {
            if (parseInt(key, 10) > slotCount) delete capturedImages[key];
        });

        totalSnapped = 0;
        let firstEmpty = 0;

        for (let i = 1; i <= slotCount; i++) {
            if (capturedImages[i]) {
                totalSnapped++;
            } else if (!firstEmpty) {
                firstEmpty = i;
            }
        }

        currentSlot = firstEmpty || 1;
        buildStrip();
        markCurrent();

        if (snappedCountEl) snappedCountEl.innerText = totalSnapped;
        if (snappedTotalEl) snappedTotalEl.innerText = slotCount;

        const selectedFrameLabel = document.getElementById('lbl-selected-frame');

        if (selectedFrameLabel) {
            selectedFrameLabel.innerText = t.name;
        }
    }

    // ========================================
    // INITIALIZE TEMPLATE DARI HOME
    // ========================================
    function initSelectedTemplate() {
        const selectedFrameId = window.WB_SELECTED_FRAME_ID;
        const selectedTemplate = templateById[selectedFrameId];

        if (!selectedTemplate) {
            console.error('Frame pilihan tidak ditemukan.', {
                diminta: selectedFrameId,
                tersedia: templateList.map(t => t.id)
            });

            // Hapus tanda // di bawah ini jika ingin menahan halaman saat debugging:
            // return;

            window.location.replace(window.WB_HOME_URL || '/home');
            return;
        }

        applyTemplate(selectedTemplate);
    }

    // Jalankan inisialisasi (WAJIB dipanggil, kalau tidak strip tidak akan muncul)
    initSelectedTemplate();

    // =====================================
    // RETAKE INDIVIDUAL SLOT (delegasi, karena slot dibuat ulang tiap ganti template)
    // =====================================
    stripCanvas?.addEventListener('click', function (event) {
        const slot = event.target.closest('.strip-slot');

        if (!slot) return;

        const idx = parseInt(slot.dataset.index, 10);

        currentSlot = idx;
        markCurrent();

        const photoEl = slot.querySelector('.slot-photo');
        const textEl = slot.querySelector('.slot-text');

        if (slot.dataset.filled === 'true') {
            photoEl?.classList.add('hidden');
            textEl?.classList.remove('hidden');

            slot.dataset.filled = 'false';
            delete capturedImages[idx];

            totalSnapped = Math.max(0, totalSnapped - 1);

            if (snappedCountEl) {
                snappedCountEl.innerText = totalSnapped;
            }

            if (shutterCaption) {
                shutterCaption.innerHTML =
                    `<span class="material-symbols-outlined text-[14px] text-[#BE185D]">restart_alt</span> Slot 0${idx} siap dijepret ulang!`;
            }
        }
    });

    // =====================================
    // RETAKE ALL
    // =====================================
    document.getElementById('btn-retake-all')
        ?.addEventListener('click', () => {
            document.querySelectorAll('.strip-slot').forEach(slot => {
                slot.querySelector('.slot-photo')?.classList.add('hidden');
                slot.querySelector('.slot-text')?.classList.remove('hidden');
                slot.dataset.filled = 'false';
            });

            Object.keys(capturedImages).forEach(key => {
                delete capturedImages[key];
            });

            totalSnapped = 0;

            if (snappedCountEl) {
                snappedCountEl.innerText = '0';
            }

            currentSlot = 1;
            markCurrent();

            if (shutterCaption) {
                shutterCaption.innerHTML =
                    `<span class="material-symbols-outlined text-[14px] text-[#BE185D]">touch_app</span> Click to capture aesthetic photobooth moment`;
            }
        });

    // =====================================
    // SAVE STRIP
    // =====================================
    document.getElementById('btn-save-strip')
        ?.addEventListener('click', () => {
            modalSave?.classList.remove('hidden');
        });

    document.getElementById('modal-save-close')
        ?.addEventListener('click', () => {
            modalSave?.classList.add('hidden');
        });

    document.getElementById('btn-download-strip')
        ?.addEventListener('click', goToDownloadPage);

    // =====================================
    // KE HALAMAN DOWNLOAD (dengan transisi tongkat peri)
    // Download file + wajib login ada di halaman download.
    // =====================================
    function goToDownloadPage() {
        const tpl = currentTemplate;

        const images = Array.from({ length: slotCount }, (_, idx) =>
            capturedImages[idx + 1] || dummyPoseImages[idx % dummyPoseImages.length]
        );

        try {
            sessionStorage.setItem('wb_strip', JSON.stringify({
                images: images,
                bg: tpl && tpl.kind === 'classic' ? tpl.bg : '#FFFFFF',
                frame: currentThemeFrameName,
                template: tpl
            }));
        } catch (e) {}

        modalSave?.classList.add('hidden');

        const target = window.WB_DOWNLOAD_URL || '/download';

        if (window.WBWand) {
            window.WBWand.play(target);
        } else {
            window.location.href = target;
        }
    }

    // =====================================
    // NAVBAR ACTIVE LINK
    // =====================================
    function updateActiveNavLink(hash) {
        document.querySelectorAll('.nav-item-link').forEach(link => {
            if (link.getAttribute('href') === hash) {
                link.className =
                    'nav-item-link px-4 py-2 rounded-full text-[13.5px] font-bold text-[#970046] bg-[#FFE4E8] hover:bg-[#FBCFE8] cursor-pointer transition-all active:scale-95';
            } else {
                link.className =
                    'nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95';
            }
        });
    }

    const brandLogo = document.getElementById('nav-brand-logo');

    brandLogo?.addEventListener('click', function (event) {
        event.preventDefault();

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        updateActiveNavLink('#hero');
    });

    document.querySelectorAll('.nav-item-link, .footer-nav-link')
        .forEach(link => {
            link.addEventListener('click', function (event) {
                const targetId = this.getAttribute('href');

                if (targetId && targetId.startsWith('#')) {
                    event.preventDefault();

                    const targetEl = document.querySelector(targetId);

                    if (targetEl) {
                        targetEl.scrollIntoView({
                            behavior: 'smooth'
                        });

                        updateActiveNavLink(targetId);
                    }
                }
            });
        });

    // =====================================
    // GUIDE MODAL
    // =====================================
    document.getElementById('nav-guide-btn')
        ?.addEventListener('click', () => {
            modalGuide?.classList.remove('hidden');
        });

    document.getElementById('modal-guide-close')
        ?.addEventListener('click', () => {
            modalGuide?.classList.add('hidden');
        });

    document.getElementById('modal-guide-dismiss')
        ?.addEventListener('click', () => {
            modalGuide?.classList.add('hidden');
        });

    document.getElementById('modal-guide-start')
        ?.addEventListener('click', () => {
            modalGuide?.classList.add('hidden');

            document.getElementById('studio')
                ?.scrollIntoView({
                    behavior: 'smooth'
                });
        });

    // =====================================
    // LOGIN MODAL
    // =====================================
    document.getElementById('nav-login-btn')
        ?.addEventListener('click', () => {
            modalLogin?.classList.remove('hidden');
        });

    document.getElementById('nav-profile-btn')
        ?.addEventListener('click', () => {
            modalLogin?.classList.remove('hidden');
        });

    document.getElementById('modal-login-close')
        ?.addEventListener('click', () => {
            modalLogin?.classList.add('hidden');
        });

    // =====================================
    // MODAL CLICK OUTSIDE
    // =====================================
    [modalGuide, modalLogin, modalSave].forEach(modal => {
        modal?.addEventListener('click', event => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // =====================================
    // FAQ ACCORDION
    // =====================================
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', function () {
            const answer = this.querySelector('.faq-answer');
            const icon = this.querySelector('.material-symbols-outlined');

            if (!answer) return;

            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');

                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                }
            } else {
                answer.classList.add('hidden');

                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
            }
        });
    });

    // =====================================
    // CONCIERGE CTA
    // =====================================
    document.getElementById('btn-concierge')
        ?.addEventListener('click', () => {
            alert(
                '🌸 Tim Atelier Concierge Whimshybooth siap membantu event photobooth impian Anda!'
            );
        });

    // // =====================================
    // // NAVBAR HIDE WHEN ENTER STUDIO
    // // =====================================
    // const navbar = document.querySelector('header');
    // const studioSection = document.querySelector('#studio');

    // if (navbar && studioSection) {
    //     function checkNavbar() {
    //         const studioTop =
    //             studioSection.getBoundingClientRect().top;

    //         const studioBottom =
    //             studioSection.getBoundingClientRect().bottom;

    //         if (studioTop <= 100 && studioBottom > 100) {
    //             navbar.classList.add('navbar-hidden');
    //         } else {
    //             navbar.classList.remove('navbar-hidden');
    //         }
    //     }

    //     window.addEventListener('scroll', checkNavbar);
    //     window.addEventListener('resize', checkNavbar);
    //     checkNavbar();
    // }
});