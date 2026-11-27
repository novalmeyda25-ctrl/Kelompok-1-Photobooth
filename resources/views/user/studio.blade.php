<!DOCTYPE html>

@include('user.partials.head')

<body class="bg-[#FFF5F7] font-sans text-[#211a1b] antialiased selection:bg-[#FBCFE8] selection:text-[#970046]">


    <main class="w-full pt-20">
        <section class="w-full px-4 sm:px-8 md:px-12 py-10 relative scroll-mt-24" id="studio">
            <div class="max-w-[1320px] mx-auto">

                @include('user.partials.studio.heading')
                @include('user.partials.studio.header-studio')


                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-8 flex flex-col gap-6">
                        @include('user.partials.studio.camera')
                        @include('user.partials.studio.filters')
                    </div>

                    @include('user.partials.studio.strip-preview')
                </div>

            </div>
        </section>
    </main>

    @include('user.partials.footer')

    {{-- Canvas tersembunyi untuk mengambil foto --}}
    <canvas id="hidden-canvas" class="hidden"></canvas>

    {{-- Modal: SESUAIKAN nama file dengan isi folder modals --}}
    @include('user.partials.modals.guide')
    @include('user.partials.modals.login')
    @include('user.partials.modals.save')

    {{-- Variabel global: harus SEBELUM script lain --}}
    <script>
        window.WB_SELECTED_FRAME_ID = @json($selectedFrameId);
        window.WB_HOME_URL = @json(route('home'));
        window.WB_DOWNLOAD_URL = @json(route('download'));
    </script>

    {{-- Urutan penting --}}
    <script src="{{ asset('js/wb-templates.js') }}"></script>
    <script src="{{ asset('js/wb-wand.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>