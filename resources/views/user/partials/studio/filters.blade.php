
{{-- CARD 2: CHOOSE YOUR MOOD --}}
<div class="w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-[0_4px_25px_rgba(244,114,182,0.14)] p-5 sm:p-6 flex flex-col">

    <div class="flex items-center justify-between pb-3.5 border-b border-[#FCE7F3]">

        <h3 class="font-serif text-[22px] font-medium text-[#970046] tracking-tight">
            Choose your mood
        </h3>

        <span class="text-[11px] font-bold text-[#BE185D] tracking-[0.14em] uppercase">
            STUDIO PHOTO FILTERS
        </span>

    </div>

    {{-- FILTER ITEMS --}}
    <div class="flex flex-nowrap gap-3 pt-4 pb-3 overflow-x-auto filter-scroll w-full min-w-0">

        {{-- Original --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border-2 border-[#BE185D] bg-[#FFE4E8]/60 transition-all text-center cursor-pointer"
                data-filter="original"
                data-filter-css="none"
                data-title="Original"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FBCFE8]"
                 style="background: linear-gradient(135deg, #FFF0F4 0%, #FCE7F3 50%, #FFE4E8 100%);">
            </div>

            <span class="text-[12.5px] font-bold text-[#970046]">
                Original
            </span>
        </button>

        {{-- Soft Glow --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="soft-glow"
                data-filter-css="contrast(102%) brightness(108%) saturate(118%) sepia(8%) hue-rotate(-8deg)"
                data-title="Soft glow"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]"
                 style="background: linear-gradient(135deg, #FFE4E8 0%, #FBCFE8 50%, #FDA4AF 100%);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Soft glow
            </span>
        </button>

        {{-- Golden Hour --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="golden-hour"
                data-filter-css="contrast(106%) brightness(105%) saturate(130%) sepia(28%)"
                data-title="Golden hour"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]"
                 style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 50%, #FED7AA 100%);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Golden hour
            </span>
        </button>

        {{-- Dreamy --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="dreamy"
                data-filter-css="contrast(98%) brightness(112%) saturate(125%) hue-rotate(295deg)"
                data-title="Dreamy"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner border border-[#FCE7F3]"
                 style="background: linear-gradient(135deg, #F3E8FF 0%, #E9D5FF 50%, #FCE7F3 100%);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Dreamy
            </span>
        </button>

        {{-- Rose --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white text-center cursor-pointer"
                data-filter="rose"
                data-filter-css="contrast(105%) brightness(106%) saturate(125%) sepia(12%)"
                data-title="Rose"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2"
                 style="background: linear-gradient(135deg, #FDA4AF, #FBCFE8, #BE185D);">
            </div>

            <span>Rose</span>
        </button>

        {{-- Lavender --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="lavender"
                data-filter-css="contrast(100%) brightness(108%) saturate(110%) hue-rotate(260deg)"
                data-title="Lavender"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
                 style="background: linear-gradient(135deg, #E9D5FF, #C4B5FD, #A78BFA);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Lavender
            </span>
        </button>

        {{-- Vintage --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="vintage"
                data-filter-css="sepia(25%) contrast(95%) brightness(105%) saturate(85%)"
                data-title="Vintage"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
                 style="background: linear-gradient(135deg, #E7C9A9, #C49A78, #8D6E63);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Vintage
            </span>
        </button>

        {{-- Fresh Garden --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="fresh-garden"
                data-filter-css="contrast(105%) brightness(105%) saturate(125%) hue-rotate(15deg)"
                data-title="Fresh Garden"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
                 style="background: linear-gradient(135deg, #D9F99D, #86EFAC, #A7F3D0);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Fresh Garden
            </span>
        </button>

        {{-- Fairy Dust --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="fairy-dust"
                data-filter-css="brightness(110%) contrast(95%) saturate(115%) sepia(10%) hue-rotate(285deg)"
                data-title="Fairy Dust"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
                 style="background: linear-gradient(135deg, #FCE7F3, #DDD6FE, #F9A8D4);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Fairy Dust
            </span>
        </button>

        {{-- Peach Bloom --}}
        <button class="filter-item w-[140px] min-w-[140px] shrink-0 p-2 rounded-2xl border border-[#FCE7F3] bg-white hover:border-[#F472B6] transition-all text-center cursor-pointer"
                data-filter="peach-bloom"
                data-filter-css="brightness(106%) saturate(115%) sepia(15%) hue-rotate(340deg)"
                data-title="Peach Bloom"
                type="button">

            <div class="w-full h-14 rounded-xl mb-2 shadow-inner"
                 style="background: linear-gradient(135deg, #FED7AA, #FDBA9A, #FBCFE8);">
            </div>

            <span class="text-[12.5px] font-medium text-[#594046]">
                Peach Bloom
            </span>
        </button>

    </div>
</div>

{{-- FAIRY ENCHANT BANNER --}}
<div class="fairy-enchant-banner">
    <img
        src="{{ asset('images/whimsybooth/fairy-enchant.png') }}"
        alt="Fairies enchant this area">
</div>
