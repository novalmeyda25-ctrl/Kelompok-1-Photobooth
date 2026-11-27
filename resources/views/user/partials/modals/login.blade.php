
{{-- LOGIN MODAL --}}
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-login">

    <div class="max-w-md w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 sm:p-7 relative animate-in fade-in duration-200">

        {{-- Close Button --}}
        <button
            aria-label="Close Login Modal"
            class="cursor-pointer absolute top-4 right-4 w-9 h-9 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center transition-all"
            id="modal-login-close"
            type="button">

            <span class="material-symbols-outlined text-[20px]">
                close
            </span>
        </button>

        {{-- Heading --}}
        <div class="text-center mb-5">

            <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#FFE4E8] to-[#FCE7F3] text-[#BE185D] flex items-center justify-center mx-auto mb-2 border border-[#FBCFE8] shadow-xs">

                <span class="material-symbols-outlined text-[26px]">
                    lock_open
                </span>

            </div>

            <h3 class="font-serif text-[24px] font-bold text-[#970046]">
                Masuk ke Whimsy Sanctuary
            </h3>

            <p class="text-[12.5px] text-[#8D7075] mt-1">
                Akses album strip tersimpan dan unduh tanpa batas resolusi tinggi
            </p>

        </div>

        {{-- Login Form --}}
        <form
            class="space-y-3.5"
            id="login-form"
            action="{{ route('login') }}"
            method="POST">

            @csrf

            {{-- Email --}}
            <div>

                <label class="block text-[11px] font-bold text-[#594046] uppercase mb-1.5 tracking-wider">
                    Email Sanctuary
                </label>

                <div class="relative">

                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#BE185D] text-[18px]">
                        mail
                    </span>

                    <input
                        class="w-full pl-10 pr-4 py-2.5 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[13px] text-[#211a1b] focus:outline-none focus:border-[#BE185D] focus:ring-1 focus:ring-[#BE185D] transition-colors"
                        placeholder="nama@fairymail.com"
                        required
                        type="email"
                        name="email"
                    />

                </div>
            </div>

            {{-- Password --}}
            <div>

                <div class="flex items-center justify-between mb-1.5">

                    <label class="text-[11px] font-bold text-[#594046] uppercase tracking-wider">
                        Kata Sandi
                    </label>

                    <a
                        class="text-[11px] text-[#BE185D] hover:underline font-semibold"
                        href="#"
                        onclick="alert('🌸 Tautan reset sandi telah dikirim ke email!'); return false;">

                        Lupa Sandi?
                    </a>
                </div>

                <div class="relative">

                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#BE185D] text-[18px]">
                        lock
                    </span>

                    <input
                        class="w-full pl-10 pr-4 py-2.5 rounded-full border border-[#FBCFE8] bg-[#FFF8F9] text-[13px] text-[#211a1b] focus:outline-none focus:border-[#BE185D] focus:ring-1 focus:ring-[#BE185D] transition-colors"
                        placeholder="••••••••"
                        required
                        type="password"
                        name="password"
                    />

                </div>
            </div>

            <button
                class="cursor-pointer w-full py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white font-bold text-[13.5px] shadow-[0_4px_16px_rgba(190,24,93,0.32)] active:scale-95 transition-all"
                type="submit">

                Masuk Sekarang
            </button>

        </form>

        {{-- Divider --}}
        <div class="relative my-4 text-center">

            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-[#FCE7F3]"></div>
            </div>

            <span class="relative bg-white px-3 text-[11px] uppercase tracking-wider text-[#8D7075] font-semibold">
                Atau lanjutkan dengan
            </span>

        </div>

        {{-- Social Login --}}
        <div class="grid grid-cols-2 gap-2.5">

            <button
                class="cursor-pointer py-2.5 px-3 rounded-full border border-[#FBCFE8] hover:bg-[#FFF0F4] text-[#594046] text-[12px] font-bold flex items-center justify-center gap-1.5 transition-all"
                onclick="WBAuth.login('Google'); alert('🌸 Masuk dengan Google berhasil!'); document.getElementById('modal-login').classList.add('hidden');"
                type="button">

                <svg class="w-4 h-4" viewbox="0 0 24 24">

                    <path d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.4l3.7 2.9C6.5 7.4 9 5 12 5z" fill="#EA4335"></path>

                    <path d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5.1 3.7-8.8z" fill="#4285F4"></path>

                    <path d="M5.6 14.7c-.2-.7-.4-1.5-.4-2.7s.1-2 .4-2.7L1.9 6.4C.7 8.8 0 10.8 0 12s.7 3.2 1.9 5.6l3.7-2.9z" fill="#FBBC05"></path>

                    <path d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.2 7.5 23 12 23z" fill="#34A853"></path>

                </svg>

                <span>Google</span>

            </button>

            <button
                class="cursor-pointer py-2.5 px-3 rounded-full border border-[#FBCFE8] hover:bg-[#FFF0F4] text-[#594046] text-[12px] font-bold flex items-center justify-center gap-1.5 transition-all"
                onclick="WBAuth.login('Apple'); alert('🌸 Masuk dengan Apple berhasil!'); document.getElementById('modal-login').classList.add('hidden');"
                type="button">

                <svg class="w-4 h-4 fill-current" viewbox="0 0 24 24">

                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.65-.79 1.1-1.89.98-3-.95.04-2.1 1.04-2.77 1.83-.59.68-1.11 1.8-1 2.89 1.07.08 2.14-.93 2.79-1.72z"></path>

                </svg>

                <span>Apple ID</span>

            </button>

        </div>

    </div>
</div>
