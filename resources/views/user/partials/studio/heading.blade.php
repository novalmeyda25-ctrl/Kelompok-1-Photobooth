
{{-- SECTION TITLE & STATUS INDICATOR --}}
<div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-3 mb-6">

    <div>

        <div class="flex items-center gap-2 mb-1">

            <span class="w-2 h-2 rounded-full bg-[#BE185D] animate-ping"></span>

            <p class="text-[11px] text-[#BE185D] font-bold tracking-[0.18em] uppercase">
                YOUR CREATIVE CORNER
            </p>

        </div>

        <h2 class="font-serif text-[38px] md:text-[44px] text-[#970046] font-normal leading-tight">
            Photobooth studio
        </h2>

        <p class="text-[14px] text-[#594046]">
            Get comfortable, find your angle, and let the fun begin.
        </p>

    </div>

    <div class="flex items-center gap-2.5">

        <button
            class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white hover:bg-[#FFE4E8] border border-[#FBCFE8] text-[#970046] text-[11px] font-bold tracking-wide transition-all shadow-xs"
            id="btn-reopen-permission"
            title="Buka Ulang Dialog Izin Kamera"
            type="button">

            <span class="material-symbols-outlined text-[14px] text-[#BE185D]">
                lock_reset
            </span>

            <span>Izin Akses Kamera</span>
        </button>

        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#FCE7F3] border border-[#FBCFE8] text-[#970046] text-[11.5px] font-bold uppercase tracking-wider shadow-xs">

            <span class="w-2 h-2 rounded-full bg-amber-400 shadow-[0_0_8px_#f59e0b]"
                  id="studio-indicator-dot">
            </span>

            <span id="studio-indicator-text">
                REQUESTING PERMISSION
            </span>

        </div>

    </div>

</div>
