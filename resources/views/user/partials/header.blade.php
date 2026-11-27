
{{-- NAVIGATION BAR --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-[#FCE7F3] shadow-[0_4px_25px_rgba(244,114,182,0.12)]">

    <div class="h-20 max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between gap-4">
    
        {{-- Brand Logo --}}
        <a aria-label="Whimshybooth Home"
           class="flex items-center gap-3 cursor-pointer group select-none transition-transform active:scale-95"
           href="#hero"
           id="nav-brand-logo">
    
            <img
                alt="Whimshybooth fairy logo"
                src="{{ asset('images/whimsybooth/fairy-logo.png') }}"
                class="h-11 w-auto object-contain group-hover:scale-110 transition-transform"
                style="filter:drop-shadow(0 2px 6px rgba(244,114,182,.55))"
            />
    
            <div class="flex items-center gap-2">
    
                <span class="wb-glow-text font-serif text-[22px] sm:text-[24px] font-bold text-[#970046] tracking-tight group-hover:text-[#BE185D] transition-colors">
                    WHIMSYBOOTH
                </span>
    
                <span class="px-2.5 py-0.5 rounded-full bg-[#FFE4E8] text-[#970046] text-[11px] font-bold hidden sm:inline-flex items-center gap-1 shadow-xs border border-[#FBCFE8]">
                    <span class="material-symbols-outlined text-[13px] text-[#E11D48]">
                        auto_awesome
                    </span>
                    Fairy Magic
                </span>
    
            </div>
        </a>
    
        {{-- Center Navigation --}}
        <nav aria-label="Main navigation" class="hidden md:flex items-center gap-1 lg:gap-2">
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-bold text-[#970046] bg-[#FFE4E8] hover:bg-[#FBCFE8] cursor-pointer transition-all active:scale-95" href="#hero">
                Home
            </a>
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#studio">
                Studio
            </a>
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#frames">
                Frames
            </a>
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#how-it-works">
                How It Works
            </a>
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#faq">
                FAQ
            </a>
    
            <a class="nav-item-link px-4 py-2 rounded-full text-[13.5px] font-semibold text-[#594046] hover:text-[#970046] hover:bg-[#FFF0F4] cursor-pointer transition-all active:scale-95" href="#contact">
                Contact
            </a>
    
        </nav>
    
        {{-- Action Buttons --}}
        <div class="flex items-center gap-2.5 relative">
    
            <button
                aria-label="Open Fairy Guide"
                class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#FFE4E8] text-[#970046] text-[12.5px] font-bold hover:bg-[#FBCFE8] shadow-xs active:scale-95 transition-all border border-[#FBCFE8]"
                id="nav-guide-btn"
                type="button">
    
                <span class="material-symbols-outlined text-[16px]">
                    menu_book
                </span>
    
                <span>Guide</span>
            </button>
    
            <button
                aria-label="Masuk ke Akun"
                class="cursor-pointer inline-flex items-center justify-center px-5 py-2 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.35)] active:scale-95 transition-all"
                id="nav-login-btn"
                type="button">
    
                Masuk
            </button>
    
            <button
                aria-label="Akun Pengguna Whimshy"
                class="cursor-pointer w-9 h-9 rounded-full bg-[#FFE4E8] text-[#970046] hover:bg-[#BE185D] hover:text-white transition-all flex items-center justify-center border border-[#FBCFE8] shadow-xs active:scale-95"
                id="nav-profile-btn"
                type="button">
    
                <span class="material-symbols-outlined text-[19px]">
                    person
                </span>
            </button>
    
        </div>
    </div>
    </header>
    