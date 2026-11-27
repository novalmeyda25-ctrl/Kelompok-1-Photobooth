
{{-- FAIRY PHOTOBOOTH QUICK GUIDE --}}
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-guide">

    <div class="max-w-md w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 sm:p-7 relative animate-in fade-in duration-200">

        {{-- Close Button --}}
        <button
            aria-label="Close Guide"
            class="cursor-pointer absolute top-4 right-4 w-9 h-9 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center transition-all"
            id="modal-guide-close"
            type="button">

            <span class="material-symbols-outlined text-[20px]">
                close
            </span>
        </button>

        {{-- Heading --}}
        <div class="flex items-center gap-3 mb-4">

            <div class="w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center shadow-xs">

                <span class="material-symbols-outlined text-[24px]">
                    menu_book
                </span>

            </div>

            <div>

                <h3 class="font-serif text-[22px] font-bold text-[#970046] leading-snug">
                    Fairy Quick Guide
                </h3>

                <p class="text-[12px] text-[#8D7075]">
                    4 Langkah Praktis Bersenang-senang di Booth
                </p>

            </div>
        </div>

        {{-- Guide Steps --}}
        <div class="space-y-2.5 my-4 text-left">

            {{-- Step 1 --}}
            <div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">

                <span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                    1
                </span>

                <div>
                    <p class="text-[13px] font-bold text-[#211a1b]">
                        Studio Mirror Ready
                    </p>

                    <p class="text-[12px] text-[#594046]">
                        Cermin live studio langsung aktif dan siap berpose tanpa install aplikasi apa pun.
                    </p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">

                <span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                    2
                </span>

                <div>
                    <p class="text-[13px] font-bold text-[#211a1b]">
                        Choose Frame &amp; Filter Mood
                    </p>

                    <p class="text-[12px] text-[#594046]">
                        Pilih tema botanical (Garden, Whispers) dan mood glow langsung pada cermin studio.
                    </p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">

                <span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                    3
                </span>

                <div>
                    <p class="text-[13px] font-bold text-[#211a1b]">
                        Pose with Timer (3s / 5s / 10s)
                    </p>

                    <p class="text-[12px] text-[#594046]">
                        Tekan Shutter untuk mengambil 4 pose berurutan dengan flash fairy yang estetik.
                    </p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="p-3 rounded-2xl bg-[#FFF8F9] border border-[#FCE7F3] flex items-start gap-3">

                <span class="w-6 h-6 rounded-full bg-[#BE185D] text-white text-[11px] font-bold flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                    4
                </span>

                <div>
                    <p class="text-[13px] font-bold text-[#211a1b]">
                        Download &amp; Print Keepsake
                    </p>

                    <p class="text-[12px] text-[#594046]">
                        Klik 'Save photo strip' untuk mengunduh format cetak PNG resolusi tinggi!
                    </p>
                </div>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-2 pt-2">

            <button
                class="cursor-pointer flex-1 py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white font-bold text-[13px] shadow-sm active:scale-95 transition-all"
                id="modal-guide-start"
                type="button">

                Ayo Mulai Foto!
            </button>

            <button
                class="cursor-pointer px-5 py-3 rounded-full border border-[#FBCFE8] bg-white text-[#8D7075] hover:text-[#970046] hover:bg-[#FFF0F4] font-semibold text-[13px] transition-all"
                id="modal-guide-dismiss"
                type="button">

                Tutup Panduan
            </button>

        </div>

    </div>
</div>
