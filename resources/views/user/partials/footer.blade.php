
{{-- FOOTER --}}
<footer class="w-full bg-[#FFF0F4] text-[#594046] border-t border-[#FCE7F3] pt-12 pb-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 pb-10 border-b border-[#FBCFE8]">

            {{-- Brand Information --}}
            <div class="lg:col-span-4 flex flex-col gap-3">

                <div class="flex items-center gap-2">

                    <img
                        alt="Whimsybooth fairy logo"
                        src="{{ asset('images/whimsybooth/fairy-logo.png') }}"
                        class="h-9 w-auto object-contain"
                        style="filter:drop-shadow(0 2px 5px rgba(244,114,182,.5))"
                    />

                    <span class="wb-glow-text font-serif text-[22px] font-bold text-[#970046]">
                        WHIMSYBOOTH
                    </span>

                </div>

                <p class="text-[13px] leading-relaxed text-[#594046] max-w-sm">
                    A Little Magic in Every Frame. Enchanted virtual photobooth memories inspired by enchanted flora, soft pink petals, and timeless celebration.
                </p>

            </div>

            {{-- Quick Navigation --}}
            <div class="lg:col-span-2 flex flex-col gap-2">

                <h4 class="text-[13px] font-bold text-[#970046]">
                    Quick Magical Trails
                </h4>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#hero">
                    Home
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#how-it-works">
                    How It Works
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#studio">
                    Photobooth Studio
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#frames">
                    Fairy Strip Gallery
                </a>

            </div>

            {{-- Support --}}
            <div class="lg:col-span-3 flex flex-col gap-2">

                <h4 class="text-[13px] font-bold text-[#970046]">
                    Enchanted Support
                </h4>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#faq">
                    FAQ / Help Sanctuary
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#frames">
                    Garden Packages
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#hero">
                    Privacy &amp; Fairy Charms
                </a>

                <a class="footer-nav-link text-[13px] text-[#594046] hover:text-[#970046] transition-colors" href="#contact">
                    Whisper to Us
                </a>

            </div>

            {{-- Newsletter --}}
            <div class="lg:col-span-3 flex flex-col gap-2">

                <h4 class="text-[13px] font-bold text-[#970046]">
                    Garden Newsletter
                </h4>

                <p class="text-[13px] text-[#594046]">
                    Receive new seasonal botanical frames, fairy dust overlays, and celebration inspirations.
                </p>

                <form
                    class="mt-1 flex items-center bg-white rounded-full p-1 pl-3 shadow-xs border border-[#FBCFE8]"
                    onsubmit="event.preventDefault(); alert('🌸 Terima kasih! Email Anda telah terdaftar.');">

                    <input
                        class="flex-1 bg-transparent text-[13px] text-[#211a1b] placeholder:text-[#8D7075] focus:outline-none"
                        placeholder="Your enchanted email..."
                        required=""
                        type="email"
                    />

                    <button
                        aria-label="Subscribe Newsletter"
                        class="w-8 h-8 rounded-full bg-[#BE185D] text-white flex items-center justify-center hover:bg-[#970046] transition-colors shadow-xs"
                        type="submit">

                        <span class="material-symbols-outlined text-[16px]">
                            arrow_forward
                        </span>

                    </button>

                </form>

            </div>

        </div>

        {{-- Copyright --}}
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-[#8D7075] text-[12px]">

            <div>
                © 2024 WHIMSYBOOTH. Crafted with fairy dew and pink starlight. All rights reserved.
            </div>

            <div class="flex items-center gap-1.5 text-[#970046] font-medium">

                <span>✿</span>

                <span>A Little Magic in Every Frame</span>

            </div>

        </div>

    </div>
</footer>
