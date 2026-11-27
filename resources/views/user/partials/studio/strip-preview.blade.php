
{{-- RIGHT COLUMN: PHOTO STRIP PREVIEW --}}
<div class="lg:col-span-4 flex flex-col">

    <div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col">

        <div class="w-full flex items-center justify-between mb-4">

            <div>
                <p class="text-[10.5px] text-[#BE185D] font-bold tracking-[0.16em] uppercase">
                    YOUR LITTLE COLLECTION
                </p>

                <h3 class="font-serif text-[26px] font-medium text-[#970046] tracking-tight">
                    Photo strip
                </h3>
            </div>

            {{-- Jumlah foto --}}
            <div class="px-3 py-1 rounded-full bg-[#FFE4E8] text-[#970046] text-[12px] font-bold border border-[#FBCFE8]">

                <span id="snapped-count">0</span> /
                <span id="snapped-total">4</span>

            </div>

        </div>

        {{-- Area Photo Strip --}}
        <div class="w-full rounded-2xl border-2 border-[#FBCFE8] shadow-inner overflow-hidden transition-all duration-300"
             id="main-strip-canvas">
        </div>

        {{-- Action Buttons --}}
        <div class="w-full mt-4 flex items-center gap-2.5">

            <button
                class="cursor-pointer flex-1 py-3 px-3 rounded-full border border-[#FBCFE8] bg-white text-[#970046] text-[12.5px] font-bold hover:bg-[#FFF0F4] flex items-center justify-center gap-1.5 transition-colors shadow-xs active:scale-95"
                id="btn-retake-all"
                type="button">

                <span class="material-symbols-outlined text-[16px] text-[#BE185D]">
                    restart_alt
                </span>

                <span>Retake all</span>
            </button>

            <button
                class="cursor-pointer flex-1 py-3 px-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[12.5px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.32)] flex items-center justify-center gap-1.5 transition-all active:scale-95"
                id="btn-save-strip"
                type="button">

                <span>Save photo strip</span>

                <span class="material-symbols-outlined text-[16px]">
                    arrow_downward
                </span>
            </button>

        </div>

        <p class="text-[11.5px] text-center text-[#8D7075] mt-3 leading-relaxed">
            Hasil snapshot cermin studio Anda langsung muncul di tiap frame slot. Klik salah satu slot kapan pun untuk retake pose tersebut.
        </p>

    </div>

</div>
