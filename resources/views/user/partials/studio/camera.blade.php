
{{-- CARD 1: MAIN CAMERA CARD --}}
<div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col relative overflow-hidden">

    {{-- Camera Top Status Bar --}}
    <div class="flex items-center justify-between text-[#8D7075] text-[11px] font-bold tracking-[0.14em] uppercase pb-3 border-b border-[#FCE7F3]">

        <div class="flex items-center gap-2 text-[#970046]">

            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse" id="cam-lens-dot"></span>

            <span id="cam-lens-title">
                WHIMSYBOOTH
            </span>

            <span class="text-[10px] px-2 py-0.5 rounded-md bg-[#FFF0F4] text-[#BE185D] border border-[#FBCFE8] lowercase font-semibold" id="cam-lens-mode">
                FAIRY & GARDEN
            </span>

        </div>

        <div class="flex items-center gap-1.5 text-[#594046]">

            <span class="material-symbols-outlined text-[14px] text-[#BE185D]">
                auto_awesome
            </span>

            <span id="cam-mood-tag">
                ORIGINAL MOOD
            </span>

        </div>

    </div>

    {{-- CAMERA VIEWFINDER --}}
    <div class="relative w-full aspect-[16/10] sm:aspect-[16/9.5] rounded-2xl overflow-hidden flex items-center justify-center transition-all duration-300 mt-4 border-2 border-[#FCE7F3] shadow-inner select-none bg-[#FFEBF0]"
         id="viewfinder">

        {{-- LIVE CAMERA FEED --}}
        <div class="relative w-full h-full overflow-hidden transition-all duration-300 filter-original"
         id="dummy-camera-feed">

            <video
                id="camera-video"
                class="w-full h-full object-cover transition-transform duration-700"
                autoplay
                playsinline
                muted>
            </video>

            {{-- Fairy Shimmer Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#970046]/35 via-transparent to-[#BE185D]/15 pointer-events-none"></div>

            <div class="absolute inset-0 bg-radial-gradient pointer-events-none mix-blend-soft-light opacity-50"
                 style="background: radial-gradient(circle, transparent 55%, rgba(190, 24, 93, 0.4) 100%);">
            </div>

            {{-- Floating Flowers --}}
            <div class="absolute top-5 right-8 text-[#FFE4E8]/80 text-[18px] pointer-events-none animate-bounce">
                🌸
            </div>

            <div class="absolute bottom-8 left-8 text-[#FFE4E8]/70 text-[14px] pointer-events-none">
                ✧
            </div>

            <div class="absolute top-1/4 left-10 text-[#FFE4E8]/60 text-[16px] pointer-events-none">
                ✨
            </div>

        </div>

        {{-- Viewfinder Corners --}}
        <div class="absolute top-3 left-3 w-6 h-6 border-t-2 border-l-2 border-[#BE185D]/70 rounded-tl pointer-events-none z-10"></div>

        <div class="absolute top-3 right-3 w-6 h-6 border-t-2 border-r-2 border-[#BE185D]/70 rounded-tr pointer-events-none z-10"></div>

        <div class="absolute bottom-3 left-3 w-6 h-6 border-b-2 border-l-2 border-[#BE185D]/70 rounded-bl pointer-events-none z-10"></div>

        <div class="absolute bottom-3 right-3 w-6 h-6 border-b-2 border-r-2 border-[#BE185D]/70 rounded-br pointer-events-none z-10"></div>

        {{-- Live Mirror Badge --}}
        <div class="absolute top-3.5 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-white/90 backdrop-blur-sm border border-[#FBCFE8] flex items-center gap-1.5 text-[10px] text-[#970046] font-bold tracking-wider uppercase shadow-xs pointer-events-none z-10">

            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"
                  id="viewfinder-mirror-dot">
            </span>

            <span id="viewfinder-mirror-badge">
                Awaiting Camera Permission
            </span>

        </div>

        {{-- Watermark --}}
        <p class="absolute bottom-3 text-center w-full text-[10px] tracking-[0.2em] text-white/90 drop-shadow-[0_1px_3px_rgba(0,0,0,0.6)] uppercase pointer-events-none font-bold z-10">
            WHIMSYBOOTH · YOUR LITTLE GARDEN
        </p>

        {{-- COUNTDOWN --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] flex items-center justify-center pointer-events-none hidden z-30"
             id="countdown-layer">

            <span class="font-serif text-[96px] text-white font-bold drop-shadow-[0_4px_20px_rgba(151,0,70,0.8)] animate-pulse"
                  id="countdown-number">
                3
            </span>

        </div>

        {{-- FLASH EFFECT --}}
        <div class="absolute inset-0 bg-white pointer-events-none opacity-0 z-40 transition-opacity duration-200"
             id="flash-effect">
        </div>

        {{-- CAMERA PERMISSION MODAL --}}
        <div class="absolute inset-0 bg-[#340d1f]/45 backdrop-blur-md flex items-center justify-center p-4 z-20 transition-all duration-300"
             id="camera-permission-modal">

            <div class="max-w-[340px] sm:max-w-[380px] w-full bg-white/95 rounded-3xl border border-[#FBCFE8] shadow-[0_10px_35px_rgba(151,0,70,0.28)] p-6 sm:p-7 text-center relative flex flex-col items-center">

                <div class="relative mb-3 flex items-center justify-center">

                    <div class="absolute inset-0 rounded-full bg-[#FCE7F3] blur-md scale-125"></div>

                    <div class="relative w-14 h-14 rounded-full bg-gradient-to-tr from-[#FFE4E8] to-[#FFF0F4] border border-[#FBCFE8] text-[#BE185D] flex items-center justify-center shadow-sm">

                        <span class="material-symbols-outlined text-[28px]">
                            photo_camera
                        </span>

                    </div>

                    <div class="absolute -top-1 -right-1 text-[13px] animate-pulse">
                        ✨
                    </div>

                </div>

                <h3 class="font-serif text-[23px] font-bold text-[#970046] leading-tight">
                    Enable Your Lens
                </h3>

                <p class="text-[12.5px] text-[#594046] mt-2 leading-relaxed">
                    Whimsybooth requests access to your optical sensor to infuse your portrait with enchanted petals and timeless crystal light.
                </p>

                {{-- Permission Buttons --}}
                <div class="w-full flex flex-col sm:flex-row items-center gap-2.5 mt-5">

                    <button class="cursor-pointer w-full flex-1 py-2.5 px-4 rounded-full bg-gradient-to-r from-[#970046] to-[#BE185D] hover:opacity-95 text-white font-bold text-[13px] shadow-[0_4px_16px_rgba(190,24,93,0.35)] flex items-center justify-center gap-1.5 transition-all active:scale-95"
                            id="btn-allow-camera"
                            type="button">

                        <span class="material-symbols-outlined text-[16px]">
                            videocam
                        </span>

                        <span>Allow Camera</span>

                    </button>

                    <button class="cursor-pointer w-full sm:w-auto py-2.5 px-5 rounded-full border border-[#FBCFE8] bg-white text-[#8D7075] hover:text-[#970046] hover:bg-[#FFF0F4] text-[12.5px] font-semibold transition-all active:scale-95"
                            id="btn-dismiss-camera"
                            type="button">

                        Dismiss

                    </button>

                </div>

                {{-- Privacy Note --}}
                <div class="mt-4 pt-3 border-t border-[#FCE7F3] flex items-center justify-center gap-1.5 text-[10.5px] text-[#8D7075] tracking-wide">

                    <span class="material-symbols-outlined text-[13px] text-[#BE185D]">
                        lock
                    </span>

                    <span>Moments remain encrypted on your device</span>

                </div>

            </div>

        </div>

        {{-- CAMERA DISMISSED FALLBACK --}}
        <div class="absolute inset-0 bg-[#FFF5F7]/95 backdrop-blur-sm hidden items-center justify-center p-4 z-20 transition-all duration-300"
             id="camera-dismissed-fallback">

            <div class="max-w-[340px] sm:max-w-[380px] w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-lg p-6 sm:p-7 text-center relative flex flex-col items-center">

                <div class="w-13 h-13 w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center mb-2.5 border border-[#FBCFE8] shadow-xs">

                    <span class="material-symbols-outlined text-[24px]">
                        videocam_off
                    </span>

                </div>

                <h3 class="font-serif text-[21px] font-bold text-[#970046]">
                    Camera Lens In Repose
                </h3>

                <p class="text-[12px] text-[#594046] mt-1.5 leading-relaxed">
                    We could not summon your video stream. Your device shutter may be obscured or claimed by another application.
                </p>

                <div class="w-full bg-[#FFF8F9] border border-[#FCE7F3] rounded-2xl p-3 my-3 text-left">

                    <p class="text-[10px] uppercase font-bold text-[#BE185D] tracking-wider mb-1">
                        TROUBLESHOOTING STEPS:
                    </p>

                    <ul class="text-[11px] text-[#594046] space-y-1 list-disc list-inside">
                        <li>Verify permissions in your browser URL lock icon.</li>
                        <li>Ensure no other video app (Zoom, Meet) holds the camera.</li>
                    </ul>

                </div>

                <div class="w-full flex items-center gap-2">

                    <button class="cursor-pointer flex-1 py-2.5 px-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[12.5px] font-bold shadow-xs transition-all active:scale-95 flex items-center justify-center gap-1"
                            id="btn-try-again-camera"
                            type="button">

                        <span class="material-symbols-outlined text-[15px]">
                            refresh
                        </span>

                        <span>Try Again</span>

                    </button>

                    <button class="cursor-pointer py-2.5 px-3.5 rounded-full border border-[#FBCFE8] bg-white text-[#970046] hover:bg-[#FFF0F4] text-[12px] font-semibold transition-all active:scale-95"
                            onclick="alert('🌸 Fitur upload dummy: Silakan coba foto langsung dengan mengizinkan kamera!');"
                            type="button">

                        Upload Photo

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- CONTROLS ROW --}}
    <div class="flex flex-wrap items-center justify-between gap-3 pt-5 mt-2 border-t border-[#FCE7F3]">

        {{-- Mirror Toggle --}}
        <button class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FCE7F3] transition-colors shadow-xs active:scale-95"
                id="btn-toggle-mirror"
                title="Toggle Cermin Horizontal (Mirror)"
                type="button">

            <span class="material-symbols-outlined text-[16px] text-[#BE185D]">
                sync_alt
            </span>

            <span id="lbl-mirror">Mirror: On</span>

        </button>

        {{-- Timer --}}
        <div class="flex items-center gap-2.5">

            <span class="text-[12.5px] font-medium text-[#594046]">
                Timer
            </span>

            <div class="inline-flex items-center bg-[#FFF0F4] rounded-full p-1 gap-1 border border-[#FBCFE8]">

                <button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-bold bg-[#BE185D] text-white shadow-xs cursor-pointer" data-sec="3" type="button">
                    3s
                </button>

                <button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-medium text-[#8D7075] hover:text-[#970046] cursor-pointer" data-sec="5" type="button">
                    5s
                </button>

                <button class="timer-opt px-3 py-1 rounded-full text-[11.5px] font-medium text-[#8D7075] hover:text-[#970046] cursor-pointer" data-sec="10" type="button">
                    10s
                </button>

            </div>
        </div>

        {{-- Flash Toggle --}}
        <button class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FCE7F3] transition-colors shadow-xs active:scale-95"
                id="btn-toggle-flash"
                type="button">

            <span class="material-symbols-outlined text-[16px] text-[#BE185D]">
                auto_awesome
            </span>

            <span id="lbl-flash">
                Flash <span class="text-[#8D7075] font-normal">Off</span>
            </span>

        </button>

    </div>

    {{-- SHUTTER BUTTON --}}
    <div class="flex flex-col items-center justify-center pt-5 pb-2">

        <div class="w-[76px] h-[76px] rounded-full border-2 border-[#F472B6] p-1.5 flex items-center justify-center shadow-[0_0_20px_rgba(244,114,182,0.35)] hover:border-[#BE185D] transition-colors">

            <button
                aria-label="Capture photo"
                class="cursor-pointer w-full h-full rounded-full bg-gradient-to-tr from-[#970046] via-[#BE185D] to-[#E11D48] hover:opacity-95 active:scale-95 transition-all shadow-[0_4px_16px_rgba(190,24,93,0.4)] flex items-center justify-center ring-2 ring-white"
                id="btn-capture-shutter"
                type="button">

                <span class="material-symbols-outlined text-white text-[30px]">
                    photo_camera
                </span>

            </button>

        </div>

        <p class="text-[12.5px] text-[#594046] mt-2.5 font-medium flex items-center gap-1"
           id="shutter-caption">

            <span class="material-symbols-outlined text-[14px] text-[#BE185D]">
                touch_app
            </span>

            Click to capture aesthetic photobooth moment

        </p>

    </div>

</div>
