
{{-- HERO SECTION --}}
<section class="relative w-full px-4 sm:px-8 py-16 text-center overflow-hidden scroll-mt-24" id="hero">

    {{-- Glow Background --}}
    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-[#FBCFE8]/40 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-10 lg:gap-4">

        {{-- Hero Text --}}
        <div class="flex flex-col items-center lg:items-start lg:text-left w-full lg:w-[52%]" id="hero-text">

            {{-- Fairy Pill --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/90 border border-[#FCE7F3] shadow-[0_2px_12px_rgba(244,114,182,0.18)] mb-6">

                <span class="material-symbols-outlined text-[#BE185D] text-[18px]">
                    auto_awesome
                </span>

                <span class="text-[12px] font-bold text-[#970046] tracking-wider uppercase">
                    Magical Bloom Atelier
                </span>

                <span class="w-1.5 h-1.5 rounded-full bg-[#E11D48]"></span>

                <span class="text-[11px] font-bold text-[#BE185D]">
                    Live 4-Cut Studio
                </span>
            </div>

            <h1 data-wb-pop class="font-serif text-[42px] sm:text-[56px] text-[#970046] font-medium leading-[1.1] mb-4">

                Step Into an Enchanted <br/>

                <span class="relative inline-block text-[#B4136D]">

                    Fairy Garden

                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-[#F472B6]/60"
                         fill="none"
                         preserveaspectratio="none"
                         viewbox="0 0 200 12">

                        <path d="M2 9C50 2 150 2 198 9"
                              stroke="currentColor"
                              stroke-linecap="round"
                              stroke-width="3">
                        </path>
                    </svg>

                </span>
            </h1>

            <p class="text-[15px] sm:text-[17px] text-[#594046] max-w-2xl leading-relaxed mb-8">
                Capture dreamy photo strips, glowing fairy dust filters, and playful botanical frames in your private garden sanctuary. Pressed petals, satin sheen, and timeless keepsake memories.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">

                <a class="cursor-pointer inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[14px] font-bold shadow-[0_8px_25px_rgba(190,24,93,0.38)] active:scale-95 transition-all"
                   href="#studio"
                   id="hero-studio-btn">

                    <span class="material-symbols-outlined text-[20px]">
                        photo_camera
                    </span>

                    Enter Photobooth Studio

                    <span class="material-symbols-outlined text-[18px]">
                        auto_awesome
                    </span>
                </a>

                <a class="cursor-pointer inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white text-[#970046] text-[14px] font-bold border border-[#FCE7F3] shadow-sm hover:bg-[#FFF0F4] transition-all active:scale-95"
                   href="#how-it-works">

                    <span class="material-symbols-outlined text-[20px] text-[#BE185D]">
                        play_circle
                    </span>

                    Watch How It Works
                </a>

            </div>
        </div>

        {{-- Lotus Image --}}
        <div class="w-full max-w-[440px] lg:max-w-none lg:w-[48%]"
             id="hero-lotus"
             data-photo="{{ asset('images/whimsybooth/lotus-open.png') }}"
             style="--wb-photo: url('{{ asset('images/whimsybooth/lotus-open.png') }}')">

            <div class="wb-lotus" id="hero-lotus-inner">
                @include('user.partials.wb-lotus')
            </div>

        </div>

    </div>
</section>
