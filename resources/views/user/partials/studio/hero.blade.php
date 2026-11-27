
{{-- PHOTOBOOTH STUDIO --}}
<section class="w-full px-4 sm:px-8 md:px-12 py-10 relative scroll-mt-24" id="studio">

    <div class="max-w-[1320px] mx-auto">

        {{-- Judul dan status studio --}}
        @include('user.partials.studio.heading')

        {{-- Layout dua kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- Kolom Kiri: Kamera dan Filter --}}
            <div class="lg:col-span-8 flex flex-col gap-6">

                {{-- Kamera --}}
                @include('user.partials.studio.camera')

                {{-- Filter --}}
                @include('user.partials.studio.filters')

            </div>

            {{-- Kolom Kanan: Photo Strip --}}
            @include('user.partials.studio.strip-preview')

        </div>

    </div>

</section>
