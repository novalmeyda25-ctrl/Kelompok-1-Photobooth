
<!DOCTYPE html>

@include('user.partials.head')

{{-- Script interaksi carousel --}}
@include('user.partials.scripts.carousel')
@include('user.partials.scripts.keyboard')

<body class="bg-[#FFF5F7] font-sans text-[#211a1b] antialiased selection:bg-[#FBCFE8] selection:text-[#970046]">

    {{-- 1. Header --}}
    @include('user.partials.header')

    <main class="w-full pt-20">

        {{-- 2. Hero --}}
        @include('user.partials.hero')

        {{-- 4. Frame Gallery --}}
        @include('user.partials.frames')

         {{-- Pesan error / peringatan setelah memilih frame --}}
         @if ($errors->any() || session('warning'))
            <div class="w-full flex justify-center px-4 -mt-6 mb-6">
                <div class="max-w-xl w-full rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-center text-sm text-red-600">
                    {{ $errors->first() ?: session('warning') }}
                </div>
            </div>
         @endif


        {{-- Konfigurasi template --}}
        <script>
          window.WB_TPL_BASE = "{{ asset('img/templates') }}";
          window.WB_TEMPLATES = @json($templates ?? null);
        </script>

        {{-- Mesin template --}}
        <script src="{{ asset('js/wb-templates.js') }}"></script>

        {{-- JavaScript pemilihan frame --}}
        <script src="{{ asset('js/home-frame-selection.js') }}" defer></script>

        {{-- 5. How It Works --}}
        @include('user.partials.how-it-works')

        {{-- 6. FAQ --}}
        @include('user.partials.faq')

        {{-- 7. Contact --}}
        @include('user.partials.contact')

    </main>

    {{-- 8. Footer --}}
    @include('user.partials.footer')

    {{-- 9. Modal --}}
    @include('user.partials.modals.guide')
    @include('user.partials.modals.login')
    @include('user.partials.modals.save')

    {{-- 10. Hidden Canvas --}}
    @include('user.partials.canvas')

    {{-- 11. JavaScript --}}
    @include('user.partials.scripts.runtime')

</body>
</html>
