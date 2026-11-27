{{-- HEADER KHUSUS HALAMAN STUDIO --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-[#FCE7F3] shadow-[0_4px_25px_rgba(244,114,182,0.12)]">

    <div class="h-20 max-w-7xl mx-auto px-4 sm:px-8 flex items-center justify-between gap-3">

        {{-- Kiri: tombol kembali + logo --}}
        <div class="flex items-center gap-3 sm:gap-4 min-w-0">

            <a href="{{ route('home') }}#frames"
               aria-label="Kembali ke pilihan frame"
               class="cursor-pointer inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[#970046] text-[12.5px] font-bold hover:bg-[#FCE7F3] shadow-xs active:scale-95 transition-all shrink-0">

                <span class="material-symbols-outlined text-[18px] text-[#BE185D]">
                    arrow_back
                </span>

                <span class="hidden sm:inline">Kembali</span>
            </a>

            <a href="{{ route('home') }}"
               aria-label="Whimsybooth Home"
               class="flex items-center gap-2.5 group select-none transition-transform active:scale-95 min-w-0">

                <img
                    alt="Whimshybooth fairy logo"
                    src="{{ asset('images/whimsybooth/fairy-logo.png') }}"
                    class="h-10 w-auto object-contain group-hover:scale-110 transition-transform"
                    style="filter:drop-shadow(0 2px 6px rgba(244,114,182,.55))"
                />

                <span class="wb-glow-text font-serif text-[20px] sm:text-[24px] font-bold text-[#970046] tracking-tight group-hover:text-[#BE185D] transition-colors truncate">
                    WHIMSYBOOTH
                </span>
            </a>

        </div>

        {{-- Kanan: guide + login / akun --}}
        <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">

            <button
                aria-label="Open Fairy Guide"
                class="cursor-pointer inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 rounded-full bg-[#FFE4E8] text-[#970046] text-[12.5px] font-bold hover:bg-[#FBCFE8] shadow-xs active:scale-95 transition-all border border-[#FBCFE8]"
                id="nav-guide-btn"
                type="button">

                <span class="material-symbols-outlined text-[16px]">
                    menu_book
                </span>

                <span class="hidden sm:inline">Guide</span>
            </button>

            @guest
                {{-- Belum login: membuka modal login (ditangani app.js) --}}
                <button
                    aria-label="Masuk ke Akun"
                    class="cursor-pointer inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.35)] active:scale-95 transition-all"
                    id="nav-login-btn"
                    type="button">

                    <span class="material-symbols-outlined text-[16px]">
                        login
                    </span>

                    <span>Masuk</span>
                </button>
            @endguest

            @auth
                {{-- Sudah login: nama pengguna + tombol keluar --}}
                <span class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-[#FFF0F4] border border-[#FBCFE8] text-[#970046] text-[12.5px] font-semibold max-w-[160px]">
                    <span class="material-symbols-outlined text-[16px] text-[#BE185D]">
                        person
                    </span>
                    <span class="truncate">{{ auth()->user()->name }}</span>
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        aria-label="Keluar"
                        class="cursor-pointer inline-flex items-center justify-center gap-1.5 px-4 sm:px-5 py-2 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-[0_4px_16px_rgba(190,24,93,0.35)] active:scale-95 transition-all">

                        <span class="material-symbols-outlined text-[16px]">
                            logout
                        </span>

                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            @endauth

        </div>
    </div>
</header>