
{{-- TEMPLATE CAROUSEL SECTION --}}
<section class="w-full px-4 sm:px-8 md:px-12 py-12 relative bg-[#FFF0F4]/60 scroll-mt-24" id="frames">

    <div class="max-w-[1320px] mx-auto flex flex-col">

        {{-- Section Heading --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-2 mb-6">

            <div>
                <p class="text-[11px] text-[#BE185D] font-bold tracking-[0.18em] uppercase mb-1">
                    MADE FOR YOUR MOMENTS
                </p>

                <h2 class="font-serif text-[36px] sm:text-[44px] text-[#970046] font-normal leading-tight">
                    Find your little frame
                </h2>

                <p class="text-[14.5px] text-[#594046]">
                    Choose a style that feels like you.
                </p>
            </div>

            <div class="px-3.5 py-1 rounded-full bg-white border border-[#FBCFE8] text-[11px] font-bold text-[#BE185D] tracking-widest uppercase shadow-xs">
                COLLECTIONS
            </div>

        </div>

        {{-- CAROUSEL --}}
        <div class="relative w-full px-2 sm:px-4">

            {{-- Previous Button --}}
            <button
                aria-label="Previous frame"
                class="cursor-pointer absolute -left-2 sm:-left-4 md:-left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 rounded-full bg-white shadow-[0_6px_20px_rgba(244,114,182,0.3)] border-2 border-[#FBCFE8] flex items-center justify-center text-[#970046] hover:bg-[#BE185D] hover:text-white hover:scale-105 active:scale-95 transition-all"
                id="carousel-prev"
                type="button">

                <span class="material-symbols-outlined text-[24px]">
                    arrow_back_ios_new
                </span>
            </button>

            {{-- Next Button --}}
            <button
                aria-label="Next frame"
                class="cursor-pointer absolute -right-2 sm:-right-4 md:-right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 md:w-14 md:h-14 rounded-full bg-white shadow-[0_6px_20px_rgba(244,114,182,0.3)] border-2 border-[#FBCFE8] flex items-center justify-center text-[#970046] hover:bg-[#BE185D] hover:text-white hover:scale-105 active:scale-95 transition-all"
                id="carousel-next"
                type="button">

                <span class="material-symbols-outlined text-[24px]">
                    arrow_forward_ios
                </span>
            </button>

            {{-- Frames Flex Container --}}
            <div class="w-full overflow-x-auto scrollbar-none py-6 px-3 flex items-stretch gap-6 transition-all scroll-smooth"
                 id="carousel-track">

                {{-- Card 1: Garden Daydream --}}
                <div
                    class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between"
                    data-bg="#FFF0F4"
                    data-template-id="garden"
                    data-frame-name="Garden"
                    data-slot="#FFE4E8">

                    <div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner"
                         style="background: radial-gradient(circle at 35% 30%, #FFE4E8 0%, #FBCFE8 50%, #FDA4AF 100%);">

                        <div class="w-10 h-10 rounded-full bg-white/80 text-[#970046] mb-3 flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 fill-current" viewbox="0 0 24 24">
                                <circle cx="12" cy="12" r="3.5"></circle>
                                <circle cx="12" cy="5.5" r="3.2"></circle>
                                <circle cx="12" cy="18.5" r="3.2"></circle>
                                <circle cx="5.5" cy="12" r="3.2"></circle>
                                <circle cx="18.5" cy="12" r="2.8"></circle>
                            </svg>
                        </div>

                        <h4 class="font-serif text-[26px] text-[#970046] lowercase leading-snug font-medium">
                            garden<br/>daydream
                        </h4>

                        <p class="text-[10.5px] tracking-[0.2em] text-[#970046] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">
                            A LITTLE BLOOM
                        </p>
                    </div>

                    <div class="mt-4 px-1 text-left">

                        <div class="flex items-center justify-between">
                            <p class="text-[17px] font-bold text-[#211a1b]">
                                Garden Daydream
                            </p>

                            <span class="material-symbols-outlined text-[#BE185D] text-[18px]">
                                check_circle
                            </span>
                        </div>

                        <p class="text-[13px] text-[#594046] mt-0.5">
                            Soft greens and little flowers
                        </p>

                    </div>
                </div>

                {{-- Card 2: Fairy Whispers --}}
                <div
                    class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between"
                    data-bg="#FAF5FF"
                    data-template-id="fairy-whispers"
                    data-frame-name="Fairy Whispers"
                    data-slot="#F3E8FF">

                    <div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner"
                         style="background: radial-gradient(circle at 75% 30%, #F5F3FF 0%, #E9D5FF 55%, #FBCFE8 100%);">

                        <div class="flex items-center gap-1 text-[#8C2049] mb-3 bg-white/70 px-2.5 py-1 rounded-full shadow-xs">
                            <span class="text-[12px]">✧</span>
                            <span class="text-[9px]">•</span>
                            <span class="text-[16px]">✦</span>
                            <span class="text-[9px]">•</span>
                            <span class="text-[12px]">✧</span>
                        </div>

                        <h4 class="font-serif text-[26px] text-[#4A1D42] lowercase leading-snug font-medium">
                            fairy<br/>whispers
                        </h4>

                        <p class="text-[10.5px] tracking-[0.2em] text-[#8C2049] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">
                            MADE OF MAGIC
                        </p>

                    </div>

                    <div class="mt-4 px-1 text-left">
                        <p class="text-[17px] font-bold text-[#211a1b]">
                            Fairy Whispers
                        </p>

                        <p class="text-[13px] text-[#594046] mt-0.5">
                            A dreamy touch of fairy dust
                        </p>
                    </div>
                </div>

                {{-- Card 3: Sweet Memories --}}
                <div
                    class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between"
                    data-bg="#FFFBEB"
                    data-template-id="sweet-memories"
                    data-frame-name="Sweet Memories"
                    data-slot="#FEF3C7">

                    <div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner"
                         style="background: radial-gradient(circle at 50% 35%, #FEF3C7 0%, #FDE68A 50%, #FBCFE8 100%);">

                        <div class="w-10 h-10 rounded-full bg-white/80 text-[#970046] mb-3 flex items-center justify-center shadow-xs">
                            <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.8" viewbox="0 0 24 24">
                                <circle cx="12" cy="12" r="2.8"></circle>
                                <circle cx="12" cy="5.5" r="2.8"></circle>
                                <circle cx="12" cy="18.5" r="2.8"></circle>
                                <circle cx="5.5" cy="12" r="2.8"></circle>
                                <circle cx="18.5" cy="12" r="2.8"></circle>
                            </svg>
                        </div>

                        <h4 class="font-serif text-[26px] text-[#78350F] lowercase leading-snug font-medium">
                            sweet<br/>memories
                        </h4>

                        <p class="text-[10.5px] tracking-[0.2em] text-[#970046] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">
                            THE GOOD OLD DAYS
                        </p>
                    </div>

                    <div class="mt-4 px-1 text-left">
                        <p class="text-[17px] font-bold text-[#211a1b]">
                            Sweet Memories
                        </p>

                        <p class="text-[13px] text-[#594046] mt-0.5">
                            A warm vintage-inspired look
                        </p>
                    </div>
                </div>

                {{-- Card 4: Blush Petals --}}
                <div
                    class="frame-card flex-1 min-w-[270px] sm:min-w-[290px] p-4 rounded-3xl border border-[#FBCFE8] bg-white hover:border-[#BE185D]/60 shadow-sm cursor-pointer transition-all duration-300 flex flex-col justify-between"
                    data-bg="#FFF0F5"
                    data-template-id="blush-petals"
                    data-frame-name="Blush Petals"
                    data-slot="#FCE7F3">

                    <div class="w-full h-52 rounded-2xl relative overflow-hidden flex flex-col items-center justify-center text-center p-5 border border-white/60 shadow-inner"
                         style="background: radial-gradient(circle at 75% 30%, #FFE4E8 0%, #F472B6/50 60%, #BE185D/30 100%);">

                        <div class="w-10 h-10 rounded-full bg-white/80 text-[#BE185D] mb-3 flex items-center justify-center shadow-xs">
                            <span class="material-symbols-outlined text-[24px]">
                                favorite
                            </span>
                        </div>

                        <h4 class="font-serif text-[26px] text-[#970046] lowercase leading-snug font-medium">
                            blush<br/>petals
                        </h4>

                        <p class="text-[10.5px] tracking-[0.2em] text-[#BE185D] uppercase mt-2 font-bold bg-white/70 px-3 py-0.5 rounded-full">
                            LOVELY LITTLE THINGS
                        </p>
                    </div>

                    <div class="mt-4 px-1 text-left">
                        <p class="text-[17px] font-bold text-[#211a1b]">
                            Blush Petals
                        </p>

                        <p class="text-[13px] text-[#594046] mt-0.5">
                            A soft pink daydream
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Selected Frame Label --}}
        <div class="mt-4 flex items-center justify-center text-center">

            <div class="px-5 py-2 rounded-full bg-white border border-[#FBCFE8] shadow-xs flex items-center gap-2">

                <span class="material-symbols-outlined text-[16px] text-[#BE185D]">
                    palette
                </span>

                <p class="text-[13.5px] text-[#594046]">
                    Selected frame:
                    <strong class="text-[#970046] font-bold" id="lbl-selected-frame">
                        Belum dipilih
                    </strong>
                </p>

            </div>
            
           
            {{-- FORM PILIH FRAME --}}
            <form
            action="{{ route('studio.choose-frame') }}"
            method="POST"
            id="frame-selection-form"
            class="mt-8 flex flex-col items-center gap-3">

            @csrf

            {{-- ID frame yang dipilih --}}
            <input
                type="hidden"
                name="frame_id"
                id="selected-frame-id"
                value="">

            {{-- Tombol menuju halaman kamera --}}
            <button
                type="submit"
                id="btn-use-frame"
                disabled
                class="px-8 py-3.5 rounded-full
                    bg-[#BE185D] text-white
                    font-bold text-sm shadow-lg
                    hover:bg-[#970046] transition-all
                    disabled:opacity-40
                    disabled:cursor-not-allowed">

                <span class="material-symbols-outlined align-middle mr-1">
                    photo_camera
                </span>

                Gunakan Frame Ini

            </button>

            <p class="text-xs text-[#8D7075]"
            id="frame-selection-message">
                Pilih salah satu frame terlebih dahulu.
            </p>

            </form>


        </div>

    </div>
</section>
