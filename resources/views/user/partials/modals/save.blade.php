
{{-- SAVE PHOTO STRIP MODAL --}}
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4" id="modal-save">

    <div class="max-w-sm w-full bg-white rounded-3xl border border-[#FBCFE8] shadow-2xl p-6 text-center relative animate-in fade-in duration-200">

        {{-- Close Button --}}
        <button
            aria-label="Close Save Modal"
            class="cursor-pointer absolute top-4 right-4 w-8 h-8 rounded-full bg-[#FFF0F4] text-[#970046] hover:bg-[#FFE4E8] flex items-center justify-center"
            id="modal-save-close"
            type="button">

            <span class="material-symbols-outlined text-[18px]">
                close
            </span>
        </button>

        {{-- Icon --}}
        <div class="w-12 h-12 rounded-full bg-[#FFE4E8] text-[#BE185D] flex items-center justify-center mx-auto mb-2">

            <span class="material-symbols-outlined text-[24px]">
                verified
            </span>

        </div>

        <h3 class="font-serif text-[24px] font-bold text-[#970046]">
            Keepsake Ready!
        </h3>

        <p class="text-[12.5px] text-[#594046] mb-4">
            Strip 4-cut hasil jepretan studio Anda siap! Lanjut ke halaman download untuk mengunduh (perlu masuk akun).
        </p>

        {{-- Action Buttons --}}
        <div class="flex flex-col gap-2">

            <button
                class="cursor-pointer w-full py-3 rounded-full bg-[#BE185D] hover:bg-[#970046] text-white text-[13px] font-bold shadow-sm flex items-center justify-center gap-1.5 active:scale-95 transition-all"
                id="btn-download-strip"
                type="button">

                <span class="material-symbols-outlined text-[18px]">
                    download
                </span>

                Lihat &amp; Download Strip
            </button>

            <button
                class="cursor-pointer w-full py-2.5 rounded-full border border-[#FBCFE8] text-[#970046] text-[12.5px] font-semibold hover:bg-[#FFF0F4] transition-all"
                onclick="document.getElementById('modal-save').classList.add('hidden');"
                type="button">

                Tutup &amp; Ambil Lagi
            </button>

        </div>

    </div>
</div>
